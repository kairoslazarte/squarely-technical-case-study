<?php

namespace App\Integrations;

use App\Integrations\Contracts\IntegrationInterface;
use App\Models\EmployeeRequest;

class IntegrationManager
{
    /** @var IntegrationInterface[] */
    private array $integrations = [];

    public function register(IntegrationInterface $integration): void
    {
        $this->integrations[$integration->name()] = $integration;
    }

    public function notifyRequestCreated(EmployeeRequest $request): void
    {
        foreach ($this->integrations as $integration) {
            $integration->onRequestCreated($request);
        }
    }

    public function notifyRequestStatusUpdated(EmployeeRequest $request, string $previousStatus): void
    {
        foreach ($this->integrations as $integration) {
            $integration->onRequestStatusUpdated($request, $previousStatus);
        }
    }

    /** @return IntegrationInterface[] */
    public function all(): array
    {
        return $this->integrations;
    }
}
