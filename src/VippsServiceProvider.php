<?php

namespace Mrdulal\LaravelVipps;

use Illuminate\Support\ServiceProvider;
use Mrdulal\LaravelVipps\Services\VippsClient;
use Mrdulal\LaravelVipps\Services\EPaymentService;
use Mrdulal\LaravelVipps\Services\CheckoutService;
use Mrdulal\LaravelVipps\Services\ExpressService;
use Mrdulal\LaravelVipps\Services\RecurringService;
use Mrdulal\LaravelVipps\Services\OrderManagementService;
use Mrdulal\LaravelVipps\Services\WebhookService;

class VippsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/vipps.php', 'vipps');

        // Register the main client
        $this->app->singleton(VippsClient::class, function ($app) {
            return new VippsClient($app['config']['vipps']);
        });

        // Register services
        $this->app->singleton(EPaymentService::class, function ($app) {
            return new EPaymentService($app[VippsClient::class]);
        });

        $this->app->singleton(CheckoutService::class, function ($app) {
            return new CheckoutService($app[VippsClient::class]);
        });

        $this->app->singleton(ExpressService::class, function ($app) {
            return new ExpressService($app[VippsClient::class]);
        });

        $this->app->singleton(RecurringService::class, function ($app) {
            return new RecurringService($app[VippsClient::class]);
        });

        $this->app->singleton(OrderManagementService::class, function ($app) {
            return new OrderManagementService($app[VippsClient::class]);
        });

        $this->app->singleton(WebhookService::class, function ($app) {
            return new WebhookService($app['config']['vipps']);
        });

        // Register the main Vipps manager
        $this->app->singleton('vipps', function ($app) {
            return new VippsManager($app);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/vipps.php' => config_path('vipps.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'vipps');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/vipps'),
        ], 'views');
    }
}