<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\EmployeeRequest;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(private readonly RequestService $requestService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $requests = $this->requestService->list($request->user());

        return response()->json($requests);
    }

    public function store(StoreRequestRequest $request): JsonResponse
    {
        $employeeRequest = $this->requestService->create(
            $request->user(),
            $request->validated()
        );

        return response()->json($employeeRequest->load('user'), 201);
    }

    public function updateStatus(UpdateStatusRequest $request, EmployeeRequest $employeeRequest): JsonResponse
    {
        $updated = $this->requestService->updateStatus(
            $employeeRequest,
            $request->validated('status')
        );

        return response()->json($updated->load('user'));
    }
}
