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
        // ダミーデータの登録
        $this->call([
            UserSeeder::class,
        ]);

        Event::factory(100)->create();
    }
}
