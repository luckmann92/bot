<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

namespace App\Http\Controllers\Telegram;

use App\Services\Telegram\StoreService;
use App\Services\Telegram\IndexService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class WebhookController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        try {
            return response()
                ->json(
                    app()->make(StoreService::class)->store($request)
                );
        } catch (\Throwable $e) {
            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 400);
        }
    }

    public function get(Request $request): JsonResponse
    {
        try {
            return response()
                ->json(
                    app()->make(IndexService::class)->get($request)
                );
        } catch (\Throwable $e) {
            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 400);
        }
    }

    public function set(Request $request): JsonResponse
    {
        try {
            return response()
                ->json(
                    app()->make(StoreService::class)->set($request)
                );
        } catch (\Throwable $e) {
            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 400);
        }
    }

    public function unset(Request $request): JsonResponse
    {
        try {
            return response()
                ->json(
                    app()->make(StoreService::class)->unset($request)
                );
        } catch (\Throwable $e) {
            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 400);
        }
    }

    public function handle(Request $request): JsonResponse
    {
        try {
            return response()->json(
                app()->make(StoreService::class)->handle($request)
            );
        } catch (\Throwable $exception) {
            return response()
                ->json([
                    'status' => false,
                    'error' => $exception->getMessage()
                ]);
        }
    }
}
