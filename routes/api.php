<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Telegram\WebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('telegram')->group(function () {
    Route::get('/set', [WebhookController::class, 'set']);
    Route::post('/event', [WebhookController::class, 'handle']);
    Route::post('/store', [WebhookController::class, 'store']);
    Route::get('/unset', [WebhookController::class, 'unset']);
    Route::get('/get', [WebhookController::class, 'get']);
});



Route::get('/setWebhook', function (Request $request) {
    return app()->make(\App\Http\Controllers\ApiController::class)->setWebhook($request);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
