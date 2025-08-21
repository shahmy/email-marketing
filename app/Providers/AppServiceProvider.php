<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\Artisan\MakeDomainModel::class,
                \App\Console\Commands\Artisan\MakeDomainAction::class,
                \App\Console\Commands\Artisan\MakeDomainBuilder::class,
                \App\Console\Commands\Artisan\MakeDomainDto::class,
                \App\Console\Commands\Artisan\MakeDomainException::class,
                \App\Console\Commands\Artisan\MakeDomainFilter::class,
                \App\Console\Commands\Artisan\MakeDomainJob::class,
                \App\Console\Commands\Artisan\MakeDomainViewModel::class,
            ]);
        }
    }
}
