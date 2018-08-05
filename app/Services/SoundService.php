<?php

namespace App\Services;

use App\Repositories\SoundRepository;
use App\Repositories\WordRepository;
use App\Sound;
use App\Word;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SoundService extends Service
{
    /** @var WordRepository $wordRepository */
    protected $wordRepository;

    /** @var SoundRepository $soundRepository */
    protected $soundRepository;

    /**
     * SoundService constructor.
     * @param WordRepository $wordRepository
     * @param SoundRepository $soundRepository
     */
    public function __construct(
        WordRepository $wordRepository,
        SoundRepository $soundRepository
    )
    {
        $this->wordRepository = $wordRepository;
        $this->soundRepository = $soundRepository;
    }

    /**
     * @param string $word
     * @param UploadedFile $file
     * @return array
     */
    public function add(string $word, UploadedFile $file): array
    {
        $words = $this->wordRepository->findByWord($word);
        if (true === $words->isEmpty()) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        $time = time();
        $path = "/files/{$time}.tmp";
        $file->storeAs("/files/", "{$time}.tmp");

        /** @var Word $word */
        $word = $words->first();

        if (true === $word->sounds->isEmpty()) {
            $sound = new Sound([
                'path' => $path,
                'word_id' => $word->id,
            ]);

            $this->soundRepository->save($sound);

            return ['ok' => true];
        }

        /** @var Sound $sound */
        $sound = $word->sounds->first();

        /** @noinspection PhpUndefinedMethodInspection */
        if (true === Storage::exists($sound->path)) {
            /** @noinspection PhpUndefinedMethodInspection */
            Storage::delete($sound->path);
        }

        $sound->path = $path;
        $this->soundRepository->save($sound);

        return ['ok' => true];
    }

    /**
     * @param string $word
     * @return array
     */
    public function get(string $word): array
    {
        $words = $this->wordRepository->findByWord($word);

        if (true === $words->isEmpty()) {
            return [
                'ok' => false,
                'errors' => ['Word not found',]
            ];
        }

        /** @var Word $word */
        $word = $words->first();

        /** @var Sound|null $sound */
        $sound = $word->sounds->first();
        if (null === $sound) {
            return [
                'ok' => false,
                'errors' => ['Sounds not found',]
            ];
        }

        /** @noinspection PhpUndefinedMethodInspection */
        if (true === Storage::exists($sound->path)) {
            /** @noinspection PhpUndefinedMethodInspection */
            return [
                'ok' => true,
                'data' => [
                    'path' => Storage::get($sound->path),
                ]
            ];
        }

        return [
            'ok' => false,
            'errors' => [
                'Unknown error',
            ]
        ];
    }

    /**
     * @param string $word
     * @return array
     */
    public function exist(string $word): array
    {
        $word = $this->wordRepository->findOneByWord($word);

        if (null === $word) {
            return [
                'ok' => false,
                'errors' => [
                    'Word not found',
                ],
            ];
        }

        $data = [
            'ok' => true,
            'data' => [
                'equals' => false === $word->sounds->isEmpty(),
            ]
        ];

        return $data;
    }
}