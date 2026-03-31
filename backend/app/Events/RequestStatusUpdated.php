<?php

namespace App\Events;

use App\Models\EmployeeRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestStatusUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly EmployeeRequest $request,
        public readonly string $previousStatus,
    ) {
    }
}
