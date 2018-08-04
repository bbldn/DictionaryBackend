<?php

namespace App\Services;

use App\Repositories\StatisticsRepository;
use App\Repositories\WordRepository;
use App\Statistics;

class StatisticsService extends Service
{
    /** @var WordRepository $wordRepository */
    protected $wordRepository;

    /** @var StatisticsRepository $statisticsRepository */
    protected $statisticsRepository;

    /**
     * StatisticsService constructor.
     * @param WordRepository $wordRepository
     * @param StatisticsRepository $statisticsRepository
     */
    public function __construct(
        WordRepository $wordRepository,
        StatisticsRepository $statisticsRepository
    )
    {
        $this->wordRepository = $wordRepository;
        $this->statisticsRepository = $statisticsRepository;
    }

    /**
     * @param string $word
     * @param int $value
     * @return array
     */
    public function set(string $word, int $value): array
    {
        $word = $this->wordRepository->findOneByWord($word);
        if (null === $word) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        if (false === $word->statistics->isEmpty()) {
            foreach ($word->statistics as $statistics) {
                $statistics->correctly = $value;
                $this->statisticsRepository->save($statistics);
            }

            return ['ok' => true];
        }

        $statistics = new Statistics([
            'correctly' => $value,
            'word_id' => $word->id,
        ]);

        $this->statisticsRepository->save($statistics);

        return ['ok' => true];
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

        /** @var Statistics|null $statistics */
        $statistics = $word->statistics->first();
        if (null === $statistics) {
            $data = [
                'ok' => true,
                'data' => [
                    'correctly' => 0,
                ]
            ];

            return $data;
        }

        $data = [
            'ok' => true,
            'data' => [
                'correctly' => $statistics->correctly,
            ]
        ];

        return $data;
    }

    /**
     * @param string $word
     * @return array
     */
    public function check(string $word): array
    {
        $word = $this->wordRepository->findOneByWord($word);
        if (null === $word) {
            return ['ok' => false, 'errors' => ['Word not found']];
        }

        if (true === $word->statistics->isEmpty()) {
            $statistics = new Statistics([
                'correctly' => 0,
                'word_id' => $word->id
            ]);

            $this->statisticsRepository->save($statistics);

            return ['ok' => true];
        }

        /** @var Statistics $statistics */
        $statistics = $word->statistics->first();
        if (5 === $statistics->correctly) {
            $word->archive = 1;
            $this->wordRepository->save($word);

            return ['ok' => true];
        }

        $statistics->correctly++;
        $this->statisticsRepository->save($statistics);

        return ['ok' => true];
    }
}