<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GenerateController;
use Illuminate\Support\Facades\Route;

/**
 * 身份认证
 */
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('info', [AuthenticationController::class, 'info']);
        Route::put('password', [AuthenticationController::class, 'passwordUpdate']);
    });
});

/**
 * 活动
 */
Route::prefix('activity')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [ActivityController::class, 'store']);
        Route::get('fields', [ActivityController::class, 'fields']);
    });
});

/**
 * 常规
 */
Route::prefix('generate')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('image', [GenerateController::class, 'image']);
    });
});
