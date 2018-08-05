<?php

namespace App\Services;

use App\Repositories\TranslationRepository;
use App\Repositories\WordRepository;
use App\Translation;
use App\Word;
use Illuminate\Support\Collection;

class GameService extends Service
{
    /** @var WordRepository $wordRepository */
    protected $wordRepository;

    /** @var TranslationRepository $translationRepository */
    protected $translationRepository;

    /**
     * GameController constructor.
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
     * @param Collection $previousWords
     * @param int $limit
     * @return array
     */
    public function start(Collection $previousWords, int $limit = 4): array
    {
        if ($this->wordRepository->numberArchiveWord() <= $previousWords->count()) {
            $data = [
                'ok' => false,
                'errors' => [
                    'Too few words',
                ]
            ];

            return $data;
        }

        $words = $this->wordRepository->findAll();
        if (false === $previousWords->isEmpty()) {
            foreach ($words as $keyWord => $_) {
                foreach ($previousWords as $keyPrevious => $__) {
                    if ($words[$keyWord]->word === $previousWords[$keyPrevious]) {
                        $words = $words->splice($keyWord, 1);
                        break;
                    }
                }
            }
        }

        if (true === $words->isEmpty()) {
            $data = [
                'ok' => false,
                'errors' => [
                    'Too few words',
                ]
            ];

            return $data;
        }

        /** @var Word $randomWord */
        $randomWord = $words->random();
        $word = $this->wordRepository->findOneByWord($randomWord->word);

        if (null === $word) {
            $data = [
                'ok' => false,
                'errors' => [
                    'Translation not found',
                ]
            ];

            return $data;
        }

        if (true === $word->translations->isEmpty()) {
            $data = [
                'ok' => false,
                'errors' => [
                    'Translation not found',
                ]
            ];

            return $data;
        }

        /** @var Translation $translation */
        $translation = $word->translations->first();
        $translations = $this->translationRepository->findOneByNotId($translation->id);

        if ($translations->count() < $limit) {
            $data = [
                'ok' => false,
                'errors' => [
                    'Too few translations',
                ]
            ];

            return $data;
        }

        /** @var Collection|Translation[] $translationsResult */
        $translationsResult = new Collection();

        for ($i = 0; $i < $limit; $i++) {
            do {
                $word = $words->random();
            } while (true === in_array($word->translation, $word->translations));

            $translationsResult->push($word->translation);
        }

        $indexRandom = rand(0, $limit - 1);

        /** @var Translation $randomTranslation */
        $randomTranslation = $translationsResult->get($indexRandom);
        $translationsResult->put($indexRandom, $translation);
        $translationsResult->push($randomTranslation);

        $data = [
            'ok' => true,
            'data' => [
                'word' => $word,
                'translations' => $translationsResult,
            ],
        ];

        return $data;
    }
}