<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

/**
 * 响应包装
 */
class ResponseService
{
    /**
     * 操作失败
     */
    public static function success(array $data = [], string $message = '操作成功'): JsonResponse
    {
        return response()->json([
            'code' => 0,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * 操作失败
     */
    public static function error(string $message = '操作失败', int $code = 1): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
}
