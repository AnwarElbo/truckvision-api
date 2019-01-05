<?php

namespace Xolvio\TruckvisionApi;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/truckvision-api.php' => config_path('truckvision-api.php'),
        ], 'truckvision-api');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/truckvision-api.php', 'truckvision-api');

        $this->app->singleton(TruckvisionApi::class, function (Container $app) {
            $config = $app->make('config');

            $endpoint = $config->get('truckvision-api.endpoint');

            return new TruckvisionApi(new Client(), $endpoint);
        });

        $this->app->alias(TruckvisionApi::class, 'truckvision.api');
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return ['truckvision.api', TruckvisionApi::class];
    }
}
