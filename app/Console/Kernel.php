<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var string[] $commands
     */
    protected $commands = [];

    /**
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        /** @noinspection PhpIncludeInspection */
        require base_path('routes/console.php');
    }
}
