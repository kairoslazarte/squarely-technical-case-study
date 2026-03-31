<?php

namespace App\Services;

use App\Events\RequestCreated;
use App\Events\RequestStatusUpdated;
use App\Models\EmployeeRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RequestService
{
    // admins get everything, employees only see their own
    public function list(User $user): Collection
    {
        if ($user->is_admin) {
            return EmployeeRequest::with('user')->latest()->get();
        }

        return $user->requests()->latest()->get();
    }

    public function create(User $user, array $data): EmployeeRequest
    {
        $request = $user->requests()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => 'pending',
        ]);

        event(new RequestCreated($request));

        return $request;
    }

    public function updateStatus(EmployeeRequest $employeeRequest, string $status): EmployeeRequest
    {
        $previous = $employeeRequest->status;

        $employeeRequest->update(['status' => $status]);

        event(new RequestStatusUpdated($employeeRequest->fresh(), $previous));

        return $employeeRequest->fresh();
    }
}
