<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

/**
 * 身份认证
 */
class AuthenticationController extends Controller
{
    /**
     * 登录
     */
    public function login(Request $request)
    {
        $input = AuthenticationService::validateLogin($request);

        AuthenticationService::ensureIsNotRateLimited($request);

        if (AuthenticationService::attemptLogin($input)) {
            return ResponseService::success(AuthenticationService::sendLoginResponse($request));
        }

        AuthenticationService::incrementLoginAttempts($request);

        return ResponseService::error("用户名或者密码错误");
    }
}
