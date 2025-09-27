<?php

namespace SushriDad\LaravelVipps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use SushriDad\LaravelVipps\Services\WebhookService;
use SushriDad\LaravelVipps\Exceptions\VippsException;

class WebhookController
{
    protected WebhookService $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle incoming webhook from Vipps.
     */
    public function handle(Request $request): JsonResponse
    {
        try {
            $result = $this->webhookService->handleWebhook($request);
            return response()->json($result, 200);
        } catch (VippsException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}