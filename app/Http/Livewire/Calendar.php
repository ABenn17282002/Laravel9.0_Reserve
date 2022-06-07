<?php

namespace App\Http\Livewire;

use Livewire\Component;
/*<初期表示で７日間増えている問題>
Carbonはミュータブル(可変)とイミュータブル(不変)がある
デフォルトはミュータブル。(現在はどちらを使用しても治っている)*/
// use Carbon\Carbon;
// 日付モジュール
use Carbon\CarbonImmutable;
// EventServiceの使用
use App\Services\EventService;

class Calendar extends Component
{
    // 現在日時、週、日付
    public $currentDate;
    public $day;
    public $currentWeek;
    // 追加
    public $sevenDaysLater;
    public $events;

    public function mount()
    {
        // 現在日時の取得
        $this->currentDate = CarbonImmutable::today();
        // 1週間後の日時取得
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        // 今週を取得する連想配列
        $this->currentWeek =[];

        // イベントの日時を取得
        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d')
        );

        for($i =0; $i<7; $i++)
        {   // 現在日時から7日分日付を作成
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
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
        $this->sevenDaysLatter = CarbonImmutable::parse($this->currentDate)->addDays(7);

        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d')
        );

        for($i=0; $i < 7; $i++)
        {
            // parseでCarbonインスタンスに変換後、日付変換
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
            // 連想配列に追加
            \array_push($this->currentWeek, $this->day);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
