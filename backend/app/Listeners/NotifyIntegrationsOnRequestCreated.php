<?php

namespace App\Listeners;

use App\Events\RequestCreated;
use App\Integrations\IntegrationManager;

class NotifyIntegrationsOnRequestCreated
{
    public function __construct(private readonly IntegrationManager $manager)
    {
    }

    public function handle(RequestCreated $event): void
    {
        $this->manager->notifyRequestCreated($event->request);
    }
}
