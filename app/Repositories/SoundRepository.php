<?php

namespace App\Repositories;

use App\Sound;

class SoundRepository extends Repository
{
    /**
     * SoundRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Sound::class);
    }
}