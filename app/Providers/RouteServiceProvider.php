<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string $namespace
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    /**
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }
}
