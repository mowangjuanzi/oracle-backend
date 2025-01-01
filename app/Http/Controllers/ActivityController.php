<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\ResponseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    /**
     * 创建
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('activities')],
            'started_at' => ['required', 'integer'],
            'ended_at' => ['required', 'integer', 'after:started_at'],
            'content' => ['nullable', 'string'],
            'forms' => ['required'],
            'is_free' => ['integer'],
            'is_audit' => ['integer'],
            'selected_num' => ['required', 'integer', 'min:1'],
        ], [], [
            'name' => '活动名称',
            'started_at' => '活动报名开始时间',
            'ended_at' => '活动报名结束时间',
        ]);

        $activity = new Activity;
        $activity->name = $input['name'];
        $activity->started_at = Carbon::createFromTimestamp($input['started_at'])->toDateTimeString();
        $activity->ended_at = Carbon::createFromTimestamp($input['ended_at'])->toDateTimeString();
        $activity->content = strval($input['content']);
        $activity->forms = $input['forms'] ?? [];
        $activity->is_free = $input['is_free'];
        $activity->is_audit = $input['is_audit'];
        $activity->selected_num = $input['selected_num'];

        $activity->save();

        return ResponseService::success();
    }

    /**
     * 返回可筛选字段
     */
    public function fields()
    {
        return ResponseService::success([
            'fields' => [
                [
                    'label' => '出生日期',
                    'value' => 'birthday',
                ],
                [
                    'label' => '民族',
                    'value' => 'nation',
                ],
                [
                    'label' => '联系电话',
                    'value' => 'mobile',
                ],
                [
                    'label' => '身份证号',
                    'value' => 'id_card',
                ],
                [
                    'label' => '邮箱',
                    'value' => 'email',
                ],
                [
                    'label' => '所在学校',
                    'value' => 'school',
                ],
                [
                    'label' => '所在年级',
                    'value' => 'class',
                ],
            ],
        ]);
    }

    public function index(Request $request)
    {
        $page = Activity::query()
            ->when($request->input('name'), function (Builder $builder, $name) {
                return $builder->where('name', 'like', "%{$name}%");
            })
            ->when($request->input('started_at'), function (Builder $builder, $startedAt) {
                return $builder->where('started_at', '>=', $startedAt);
            })
            ->when($request->input('ended_at'), function (Builder $builder, $endedAt) {
                return $builder->where('started_at', '<=', $endedAt);
            })
            ->orderByDesc('id')
            ->paginate();

    }
}
