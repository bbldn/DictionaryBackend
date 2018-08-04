<?php

namespace App\Repositories;

use App\Statistics;

class StatisticsRepository extends Repository
{
    /**
     * StatisticsRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Statistics::class);
    }
}