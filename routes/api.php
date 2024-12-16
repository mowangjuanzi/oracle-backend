<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

/**
 * 身份认证
 */
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::get('info', [AuthenticationController::class, 'info'])->middleware('auth:sanctum');
});
