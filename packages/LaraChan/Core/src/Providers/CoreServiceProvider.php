<?php

namespace LaraChan\Core\Providers;

use Illuminate\Support\ServiceProvider;

use LaraChan\Core\Commands\Install;
use LaraChan\Core\Commands\Populate;
use LaraChan\Core\Commands\Monitor;
use LaraChan\Core\Commands\CreateBoard;
use LaraChan\Core\Commands\Boards;
use LaraChan\Core\Commands\DeleteBoard;
use LaraChan\Core\Commands\DeleteThread;
use LaraChan\Core\Commands\DeleteReply;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');

        // $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        // $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'larachan');

        // $this->publishes([
        //     __DIR__ . '/../../publishable/assets' => public_path('vendor/lc/assets'),
        // ], 'public');

        // $this->publishes([
        //     __DIR__ . '/../../publishable/LaraChan.php' => config_path('LaraChan.php'),
        // ], 'public');

        // $this->commands([
        //     Install::class,
        //     Populate::class,
        //     Monitor::class,
        //     CreateBoard::class,
        //     Boards::class,
        //     DeleteBoard::class,
        //     DeleteThread::class,
        //     DeleteReply::class,
        // ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
