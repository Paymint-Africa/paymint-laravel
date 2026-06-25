<?php
namespace PayMint\Laravel;

use Illuminate\Support\ServiceProvider;
use PayMint\PayMintClient;

class PayMintServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/paymint.php' => config_path('paymint.php'),
            ], 'paymint-config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/paymint.php', 'paymint');

        $this->app->singleton('paymint', function ($app) {
            $secretKey = config('paymint.secret_key');
            $baseUrl = config('paymint.base_url');
            
            return new PayMintClient($secretKey, $baseUrl);
        });
    }
}
