<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Hash;

trait CreatesApplication
{
    /**
     * @return Application
     */
    public function createApplication(): Application
    {
        /** @var Application $app */
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        /** @noinspection PhpUndefinedMethodInspection */
        Hash::driver('bcrypt')->setRounds(4);

        return $app;
    }
}
