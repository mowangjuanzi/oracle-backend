<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    /**
     * 当前登录用户的基础信息
     */
    public function info(Request $request)
    {
        /** @var User $auth */
        $auth = $request->user();

        return ResponseService::success([
            "nickname" => $auth->nickname,
            "roles" => [$auth->id === 1 ? "admin" : "editor"],
        ]);
    }
}
