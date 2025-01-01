<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 活动
 *
 * @property int $id 主键
 * @property string $name 活动名称
 * @property string $started_at 活动开始时间
 * @property string $ended_at 活动结束时间
 * @property string $content 活动内容
 * @property int $is_free 是否收费
 * @property int $is_audit 是否审核
 * @property array $forms 表单字段
 * @property int $selected_num 选中人数
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 */
class Activity extends Model
{
    protected $casts = [
        'forms' => 'array',
    ];
}
