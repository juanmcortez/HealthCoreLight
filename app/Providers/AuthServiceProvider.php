<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\DemographicsUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Auth::provider('demographics', static function ($app, array $config) {
            return new DemographicsUserProvider($app['hash'], $config['model']);
        });
    }
}
