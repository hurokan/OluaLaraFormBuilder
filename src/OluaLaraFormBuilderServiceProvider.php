<?php

namespace rokan\olualaraformbuilder;
use Illuminate\Support\ServiceProvider;
use rokan\olualaraformbuilder\Interfaces\ApiConsumeInterface;
use rokan\olualaraformbuilder\Services\ApiConsumeService;

class OluaLaraFormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */

    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'olualaraformbuilder');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'olualaraformbuilder');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('olualaraformbuilder.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/olualaraformbuilder'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/olualaraformbuilder'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/olualaraformbuilder'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
//            dd(__DIR__);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'olualaraformbuilder');

//        $this->loadViewsFrom(__DIR__.'/../resources/views', 'olualaraformbuilder');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'olualaraformbuilder');

        // Register the main class to use with the facade
        $this->app->singleton('olualaraformbuilder', function () {
            return new olualaraformbuilder;
        });
        $this->app->make('rokan\olualaraformbuilder\SingleFormBuilderController');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'olualaraformbuilder');
        $this->app->bind(ApiConsumeInterface::class, ApiConsumeService::class);


    }
}
