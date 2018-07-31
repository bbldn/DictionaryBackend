<?php

namespace App\Services;

use App\Repositories\TranslationRepository;
use App\Repositories\WordRepository;
use App\Translation;
use Illuminate\Support\Collection;

class TranslationService extends Service
{
    /** @var WordRepository $wordRepository */
    protected $wordRepository;

    /** @var TranslationRepository $translationRepository */
    protected $translationRepository;

    /**
     * TranslationService constructor.
     * @param WordRepository $wordRepository
     * @param TranslationRepository $translationRepository
     */
    public function __construct(
        WordRepository $wordRepository,
        TranslationRepository $translationRepository
    )
    {
        $this->wordRepository = $wordRepository;
        $this->translationRepository = $translationRepository;
    }

    /**
     * @param string $word
     * @return array
     */
    public function get(string $word): array
    {
        $word = $this->wordRepository->findOneByWord($word);
        if (null === $word) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        $translations = $word->translations->map(function ($translation) {
            /** @var Translation $translation */
            return $translation->translation;
        });

        $data = [
            'ok' => true,
            'data' => [
                'length' => $translations->count(),
                'translations' => $translations,
            ],
        ];

        return $data;
    }

    /**
     * @param string $word
     * @param int $limit
     * @return array
     */
    public function getRandom(string $word, int $limit): array
    {
        $word = $this->wordRepository->findOneByWord($word);
        if (null === $word) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        if ($word->translations->count() < $limit) {
            $limit = $word->translations->count();
        }

        $translations = new Collection();
        for ($i = 0; $i < $limit; $i++) {
            do {
                /** @var Translation $translation */
                $translation = $word->translations->random();
            } while (false !== $translations->search($translation->translation));

            $translations->push($translation->translation);
        }

        $data = [
            'ok' => true,
            'data' => [
                'translations' => $translations,
            ]
        ];

        return $data;
    }

    /**
     * @param string $word
     * @param string $translation
     * @return array
     */
    public function check(string $word, string $translation): array
    {
        $word = $this->wordRepository->findOneByWord($word);
        if (null === $word) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        $equals = false;
        foreach ($word->translations as $item) {
            if ($item->translation === $translation) {
                $equals = true;
                break;
            }
        }

        $data = [
            'ok' => true,
            'data' => [
                'equals' => $equals,
            ]
        ];

        return $data;
    }
}