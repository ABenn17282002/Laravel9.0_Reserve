<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /* 10時～20時 30分単位で設定 */
        //10時～18時
        $availableHour = $this->faker->numberBetween(10, 18);
        // 00分か 30分
        $minutes = [0, 30];
        //ランダムにキーを取得
        $mKey = array_rand($minutes);
        // イベント時間 1時間～3時間
        $addHour = $this->faker->numberBetween(1, 3);


        // 日付のダミーデータは１か月分
        $dummyDate = $this->faker->dateTimeThisMonth;
        // 開始時間(10-18時までとランダムな時間)
        $startDate = $dummyDate->setTime($availableHour,$minutes[$mKey]);

        /* 終了時間 */
        // そのまま修正すると開始日時も変わるのでコピーする
        $clone = clone $startDate;
        // 終了時間(開始時間+イベント時間)
        $endDate =$clone->modify('+'.$addHour.'hour');

        // fakerによるダミーデータ生成
        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1,20),
            'start_date' => $startDate,
            // 終了時刻は
            'end_date' => $endDate,
            'is_visible' => $this->faker->boolean
        ];
    }
}
