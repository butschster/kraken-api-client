<?php

namespace Butschster\Kraken;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class KrakenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerClient();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/kraken.php';
        $this->mergeConfigFrom($configPath, 'kraken');
    }

    protected function registerClient(): void
    {
        $this->app->singleton(Contracts\Client::class, function () {
            $config = $this->app->make('config')->get('kraken', []);

            return new Client(
                new HttpClient(),
                $config['key'] ?? null,
                $config['secret'] ?? null,
                $config['otp'] ?? null
            );
        });
    }
}
