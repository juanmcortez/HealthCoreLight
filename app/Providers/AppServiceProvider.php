<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

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
        // catch N+1 issues in local / staging
        Model::preventLazyLoading(!app()->isProduction());

        // catch relationship mistakes
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
    }
}
