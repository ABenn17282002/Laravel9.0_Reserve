<?php

namespace App\Services;

// DBクラスとCarbonカレンダー
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MyPageService
{
    public static function reservedEvent($events, $string)
    {
        $reservedEvents = [];

        if($string == 'fromToday'){
            // 開始日を昇順で取得
            foreach($events->sortBy('start_date') as $event)
            {
                // キャンセル日が空でありかつ、開始日が本日以降
                if(is_null($event->pivot->canceled_date) &&
                $event->start_date >= Carbon::now()->format('Y-m-d 00:00:00'))
                {
                    $eventInfo =[
                        // Eventid
                        'id'=> $event->id,
                        // Event名
                        'name'=> $event->name,
                        // 開始日
                        'start_date'=> $event->start_date,
                        // 終了日
                        'end_date'=> $event ->end_date,
                        // 予約人数
                        'number_of_people'=>$event->pivot->number_of_people,
                    ];

                    // $reservedEventsの配列に$eventInfoの情報を追加
                    \array_push($reservedEvents, $eventInfo);
                }
            }
        }

        if($string == 'past')
        {
            // 開始日を降順で取得
            foreach($events->sortByDesc('start_date') as $event)
            {
                // キャンセル日が空でありかつ、開始日が本日より前の場合
                if(is_null($event->pivot->canceled_date) &&
                $event->start_date < Carbon::now()->format('Y-m-d 00:00:00'))
                {
                    $eventInfo =[
                        // Eventid
                        'id'=> $event->id,
                        // Event名
                        'name'=> $event->name,
                        // 開始日
                        'start_date'=> $event->start_date,
                        // 終了日
                        'end_date'=> $event ->end_date,
                        // 予約人数
                        'number_of_people'=>$event->pivot->number_of_people,
                    ];

                    // $reservedEventsの配列に$eventInfoの情報を追加
                    \array_push($reservedEvents, $eventInfo);
                }
            }
        }

        return $reservedEvents;
    }
}
