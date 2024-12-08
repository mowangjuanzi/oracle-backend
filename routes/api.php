<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

/**
 * 身份认证
 */
Route::post("login", [AuthenticationController::class, 'login']);
