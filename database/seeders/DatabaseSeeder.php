<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Eventモデルの追加
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 事前にイベント,User情報を登録する
        Event::factory(100)->create();
        // ダミーデータの登録
        $this->call([
            UserSeeder::class,
            // 予約情報のSeeder作成
            ReservationSeeder::class
        ]);

    }
}
