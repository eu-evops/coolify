<?php

use App\Http\Controllers\Api\ApplicationsController;
use App\Http\Controllers\Api\OtherController;
use App\Http\Middleware\ApiAllowed;
use Illuminate\Support\Facades\Route;

Route::get('/health', [OtherController::class, 'healthcheck']);
Route::group([
    'prefix' => 'v1',
], function () {
    Route::get('/health', [OtherController::class, 'healthcheck']);
});

Route::group([
    'middleware' => ['auth:sanctum', ApiAllowed::class, 'api.sensitive'],
    'prefix' => 'v1',
], function () {

    Route::get('/applications/{uuid}/prs/{pr}/logs', [ApplicationsController::class, 'pr_logs_by_uuid'])->middleware(['api.ability:read']);
});

Route::any('/{any}', function () {
    return response()->json(['message' => 'Not found.', 'docs' => 'https://coolify.io/docs'], 404);
})->where('any', '.*');
