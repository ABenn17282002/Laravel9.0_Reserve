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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // UserID:外部制約,多テーブル削除時同時削除
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            // eventID:外部制約,多テーブル削除時同時削除
            $table->foreignId('event_id')->constrained()->onUpdate('cascade');
            // 予約人数
            $table->integer('number_of_people');
            // キャンセル対応
            $table->datetime('canceled_date')->nullable();
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
        Schema::dropIfExists('reservations');
    }
};
