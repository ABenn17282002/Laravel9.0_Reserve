<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // イベント名
            $table->string('name');
            // イベント内容
            $table->text('information');
            // 最大人数
            $table->integer('max_people');
            // 開始日時
            $table->datetime('start_date');
            // 終了日時
            $table->datetime('end_date');
            // 表示・非表示
            $table->boolean('is_visible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
