<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        RateLimiter::for('contact', fn (Request $request) => Limit::perDay(5)->by($request->ip()));
        RateLimiter::for('reviews', fn (Request $request) => Limit::perDay(3)->by($request->ip()));
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
        RateLimiter::for('questions', fn (Request $request) => Limit::perDay(10)->by($request->ip()));
    }
}
