<?php

namespace App\Integrations\Contracts;

use App\Models\EmployeeRequest;

interface IntegrationInterface
{
    public function name(): string;

    public function onRequestCreated(EmployeeRequest $request): void;

    public function onRequestStatusUpdated(EmployeeRequest $request, string $previousStatus): void;
}
