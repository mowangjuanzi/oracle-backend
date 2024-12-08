<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticationService
{
    /**
     * 表单验证登录
     */
    public static function validateLogin(Request $request): array
    {
        return $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     * 检测是否存在频率限制
     */
    public static function ensureIsNotRateLimited(Request $request): void
    {
        $throttleKey = self::throttleKey($request);

        if (!RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * 获取频率限制的 key
     */
    protected static function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('username')) . '|' . $request->ip());
    }

    /**
     * 尝试登录
     * @param array{username: string, password: string} $credentials
     */
    public static function attemptLogin(array $credentials)
    {
        /** @var EloquentUserProvider $provider */
        $provider = Auth::getProvider();
        $user = $provider->retrieveByCredentials($credentials);

        if ($user && $provider->validateCredentials($user, $credentials)) {
            Auth::setUser($user);
            return true;
        }

        return false;
    }

    /**
     * 发送登录成功后的响应
     * @return array{token: string}
     */
    public static function sendLoginResponse(Request $request): array
    {
        self::clearLoginAttempts($request);

        /** @var User $user */
        $user = Auth::user();
        $user['remember_token'] = hash('sha256', $plainTextToken = Str::random(40));
        $user['token_expired_at'] = Carbon::now()->addDays(config('bsr.token_ttl'));
        $user->save();

        return [
            "token" => $plainTextToken
        ];
    }

    /*
     * 清除登录锁
     */
    protected static function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear(self::throttleKey($request));
    }

    /**
     * 设置下次允许登录时间
     */
    public static function incrementLoginAttempts(Request $request): void
    {
        RateLimiter::hit(self::throttleKey($request), 60);
    }
}
