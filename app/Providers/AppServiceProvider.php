<?php

namespace App\Providers;

use App\View\Components\FilamentWidgetComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Trust proxy headers
        // Request::setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_ALL);
        
        // Force HTTPS
        URL::forceScheme('https');
        
        // Force root URL
        URL::forceRootUrl(config('app.url'));
    }
}
