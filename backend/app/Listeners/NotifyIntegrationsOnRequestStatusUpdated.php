<?php

namespace App\Listeners;

use App\Events\RequestStatusUpdated;
use App\Integrations\IntegrationManager;

class NotifyIntegrationsOnRequestStatusUpdated
{
    public function __construct(private readonly IntegrationManager $manager)
    {
    }

    public function handle(RequestStatusUpdated $event): void
    {
        $this->manager->notifyRequestStatusUpdated($event->request, $event->previousStatus);
    }
}
