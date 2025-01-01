<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * 通用控制器
 */
class GenerateController extends Controller
{
    /**
     * 上传图片
     */
    public function image(Request $request)
    {
        $input = $request->validate([
            'image' => [
                'required', 'image',
            ],
        ]);

        /** @var UploadedFile $image */
        $image = $input['image'];

        $path = $image->store();

        return ResponseService::success([
            'link' => $path,
        ]);
    }
}
