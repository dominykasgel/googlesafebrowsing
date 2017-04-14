<?php

namespace dominykasgel\GoogleSafeBrowsing;

use Illuminate\Support\ServiceProvider;

class GoogleSafeBrowsingServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * Create a config file for Google Safe Browsing API key.
     *
     * @return void
     */

    public function boot()
    {
        $this->publishes( [
            __DIR__.'/config/google_safe_browsing.php' => config_path('google_safe_browsing.php'),
        ] );
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register() {

        $this->app->bind('GoogleSafeBrowsing', function ($app) {
            return new GoogleSafeBrowsing;
        });

    }

}