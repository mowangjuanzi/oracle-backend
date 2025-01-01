<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('姓名');
            $table->timestamp('started_at')->nullable()->comment('开始时间');
            $table->timestamp('ended_at')->nullable()->comment('结束时间');
            $table->text('content')->nullable()->comment('内容');
            $table->tinyInteger('is_free')->default(0)->comment('是否收费');
            $table->tinyInteger('is_audit')->default(0)->comment('是否审核');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->string('forms')->default('[]')->comment('表单字段');
            $table->integer('selected_num')->default(0)->comment('筛选人数');
            $table->timestamps();
            $table->comment('活动');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
