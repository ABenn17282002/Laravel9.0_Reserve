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

    /** 編集時の重複イベント確認
    * 1. 日付の重複が無いなら重複していない。
    * 2. 日付の重複が自身なら重複していない。
    * 3. 日付の重複が他のイベントなら重複している。
    */
    public static function checkEventDuplicationExceptOwn($ownEventId, $eventDate,
    $startTime, $endTime)
    {
        $event = DB::table('events')
		->whereDate('start_date', $eventDate)
		->whereTime('end_date', '>', $startTime)
		->whereTime('start_date', '<', $endTime)
		->get()       //データの取得
		->toArray(); // 配列化

        // そもそも日付が重複していない
        if (empty($event)) {
            return false;
        }

        // 重複があったイベントのidを取得
        $eventId = $event[0]->id;

        // 重複していたイベントが自身の場合、重なっていないと判定
        if ($ownEventId === $eventId) {
            return false;
        } else {
            return true;
        }
    }

    /** 開始及び終了時間作成関数
    *   日時+開始及び終了時間⇒Carbonモジュールで日付変換
    */
    public static function joinDateAndTime($date,$time)
    {
        $join = $date. "" . $time;
        return Carbon::createFromFormat('Y-m-d H:i', $join);
    }

    // 指定期間のイベント取得用関数
    public static function getWeekEvents($startDate,$endDate)
    {
        // キャンセル分を除いた合計を計算する
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id');

        // 開始日時を本日以前のものを降順に取得
        return DB::table('events')
        ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
            $join->on('events.id','=', 'reservedPeople.event_id');
        })
        ->whereBetween('start_date',[$startDate,$endDate])
        ->orderBy('start_date','desc')
        ->get();
    }
}
