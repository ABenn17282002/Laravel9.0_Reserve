<?php

// 名前空間の利用
namespace App\Services;

// DBファザード
use Illuminate\Support\Facades\DB;
// 日付モジュール
use Carbon\Carbon;

class EventService
{
    /** 登録時間重複確認関数
    * 新規の開始時間  < 登録済みの終了時間
    * and
    * 新規の終了時間 > 登録済みの開始時間
    * 例) 登録済み  A 10:00 - 12:00, B 13:00 - 15:00
    * 新規 11:00-14:00 ＝> 11:00-12:00と13:00-14:00まで重複NG
    */
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
        ->whereDate('start_date', $eventDate)  // 日時
        ->whereTime('end_date' ,'>',$startTime)
        ->whereTime('start_date', '<', $endTime)
        ->exists(); // 存在確認
    }

    /** 開始及び終了時間作成関数
    *   日時+開始及び終了時間⇒Carbonモジュールで日付変換
    */
    public static function joinDateAndTime($date,$time)
    {
        $join = $date. "" . $time;
        return Carbon::createFromFormat('Y-m-d H:i', $join);

    }
}
