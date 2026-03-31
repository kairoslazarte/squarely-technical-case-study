<?php

namespace App\Providers;

use App\Integrations\Google\GoogleCalendarIntegration;
use App\Integrations\IntegrationManager;
use App\Integrations\Shopify\ShopifyIntegration;
use App\Listeners\NotifyIntegrationsOnRequestCreated;
use App\Listeners\NotifyIntegrationsOnRequestStatusUpdated;
use App\Events\RequestCreated;
use App\Events\RequestStatusUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IntegrationManager::class, function () {
            $manager = new IntegrationManager();

            $manager->register(new GoogleCalendarIntegration());
            $manager->register(new ShopifyIntegration());

            return $manager;
        });
    }

    public function boot(): void
    {
        Event::listen(RequestCreated::class, NotifyIntegrationsOnRequestCreated::class);
        Event::listen(RequestStatusUpdated::class, NotifyIntegrationsOnRequestStatusUpdated::class);
    }
}
