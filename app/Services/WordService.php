<?php

namespace App\Services;

use App\Repositories\TranslationRepository;
use App\Repositories\WordRepository;
use App\Translation;
use App\Word;
use Illuminate\Support\Collection;

class WordService extends Service
{
    /** @var WordRepository $wordRepository */
    protected $wordRepository;

    /** @var TranslationRepository $translateRepository */
    protected $translateRepository;

    /**
     * WordService constructor.
     * @param WordRepository $wordRepository
     * @param TranslationRepository $translateRepository
     */
    public function __construct(
        WordRepository $wordRepository,
        TranslationRepository $translateRepository
    )
    {
        $this->wordRepository = $wordRepository;
        $this->translateRepository = $translateRepository;
    }

    /**
     * @param string $word
     * @param string $translation
     * @return array
     */
    public function add(string $word, string $translation): array
    {
        $wordWord = $word;

        $word = $this->wordRepository->findOneByWord($wordWord);

        if (null !== $word) {
            $data = [
                'ok' => false,
                'errors' => [
                    'Word already exists',
                ]
            ];

            return $data;
        }

        $word = new Word([
            'word' => $wordWord,
        ]);

        $this->wordRepository->save($word);

        $translation = new Translation([
            'translation' => $translation,
            'word_id' => $word->id,
        ]);

        $this->translateRepository->save($translation);

        $data = [
            'ok' => true,
            'data' => [
                'id' => $word->id,
            ],
        ];

        return $data;
    }

    public function get(string $translation): array
    {
        $translations = $this->translateRepository->findByTranslation($translation);
        $wordsWords = $translations->map(function ($translation) {
            /** @var Translation $translation */
            return $translation->word->word;
        });

        $data = [
            'ok' => true,
            'data' => [
                'length' => $wordsWords->count(),
                'words' => $wordsWords,
            ]
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $words = $this->wordRepository->findAll();

        $words = $words->map(function ($word) {
            /** @var Word $word */
            return $word->word;
        });

        $data = [
            'ok' => true,
            'data' => [
                'length' => $words->count(),
                'words' => $words
            ]
        ];

        return $data;
    }

    /**
     * @param Collection $previousWords
     * @return array
     */
    public function getRandom(Collection $previousWords): array
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
            $words = $words->filter(function ($item) use ($previousWords) {
                /** @var Word $item */
                return false === $previousWords->search($item->word);
            });

            $words = $words->sort();
        }

        /** @var Word $word */
        $word = $words->random();

        $data = [
            'ok' => true,
            'data' => [
                'word' => $word->word,
            ]
        ];

        return $data;
    }

    /**
     * @param string $word
     * @return array
     */
    public function addToArchive(string $word): array
    {
        $word = $this->wordRepository->findOneByWord($word);

        if (null === $word) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        $word->archive = 1;

        $this->wordRepository->save($word);

        return ['ok' => true];
    }

    /**
     * @param string $json
     * @return array
     */
    public function addAllWords(string $json): array
    {
        $array = json_decode($json);

        if (false === $array || false === key_exists('words', $array)) {
            return ['ok' => false, 'errors' => ['Wrong format']];
        }

        foreach ($array['words'] as $row) {
            if (false === key_exists('word', $row) || false === key_exists('translate', $row)) {
                return ['ok' => false, 'errors' => ['The error in the file']];
            }

            $word = new Word([
                'word' => $row['word'],
            ]);

            $this->wordRepository->save($word);

            $translation = new Translation([
                'translation' => $row['translate'],
                'word_id' => $word->id,
            ]);

            $this->translateRepository->save($translation);
        }

        return ['ok' => true];
    }
}