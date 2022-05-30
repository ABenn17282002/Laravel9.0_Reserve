<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Calendar extends Component
{
    // 現在日時、週、日付
    public $currentDate;
    public $day;
    public $currentWeek;

    public function mount()
    {
        // 現在日時の取得
        $this->currentDate = Carbon::today();
        // 今週を取得する連想配列
        $this->currentWeek =[];

        for($i =0; $i<7; $i++)
        {   // 現在日時から7日分日付を作成
            $this->day = Carbon::today()->addDays($i)->format('m月d日');
            // 連想配列に追加
            \array_push($this->currentWeek, $this->day);
        }

        // dd($this->currentWeek);
    }

    // 日付取得用関数
    public function getDate($date)
    {
        // 現在日時の文字列化
        $this->currentDate = $date;
        $this->currentWeek =[];

        for($i=0; $i < 7; $i++)
        {
            // parseでCarbonインスタンスに変換後、日付変換
            $this->day = Carbon::parse($this->currentDate)->addDays($i)->format('m月d日');
            // 連想配列に追加
            \array_push($this->currentWeek, $this->day);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
