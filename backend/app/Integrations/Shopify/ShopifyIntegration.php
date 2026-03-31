<?php

namespace App\Integrations\Shopify;

use App\Integrations\Contracts\IntegrationInterface;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Log;

// placeholder - idea is to trigger store credit on approved reimbursements
class ShopifyIntegration implements IntegrationInterface
{
    public function name(): string
    {
        return 'shopify';
    }

    public function onRequestCreated(EmployeeRequest $request): void
    {
        // nothing to do here
    }

    public function onRequestStatusUpdated(EmployeeRequest $request, string $previousStatus): void
    {
        if ($request->type !== 'reimbursement' || $request->status !== 'approved') {
            return;
        }

        // TODO: call shopify api to issue store credit

        Log::info('[Shopify] Would issue store credit for approved reimbursement', [
            'request_id' => $request->id,
            'user' => $request->user->name,
        ]);
    }
}
