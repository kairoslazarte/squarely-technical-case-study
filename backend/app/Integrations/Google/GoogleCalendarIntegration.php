<?php

namespace App\Integrations\Google;

use App\Integrations\Contracts\IntegrationInterface;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Log;

// not wired up yet - needs google/apiclient + oauth flow
class GoogleCalendarIntegration implements IntegrationInterface
{
    public function name(): string
    {
        return 'google_calendar';
    }

    public function onRequestCreated(EmployeeRequest $request): void
    {
        if ($request->type !== 'leave') {
            return;
        }

        // TODO: hook up google api client here

        Log::info('[GoogleCalendar] Would create calendar event for leave request', [
            'request_id' => $request->id,
            'user' => $request->user->name,
        ]);
    }

    public function onRequestStatusUpdated(EmployeeRequest $request, string $previousStatus): void
    {
        if ($request->type !== 'leave') {
            return;
        }

        // TODO: update/cancel event depending on status
        Log::info('[GoogleCalendar] Would update calendar event', [
            'request_id' => $request->id,
            'status' => $request->status,
            'previous_status' => $previousStatus,
        ]);
    }
}
