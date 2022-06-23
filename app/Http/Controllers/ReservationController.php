<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
// DBファザード
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return \view('dashboard');
    }

    public function detail($id)
    {
        // eventIDを取得
        $event = Event::findOrFail($id);

        $reservedPeople = DB::table('reservations')
        // select内でsumを使うため、クエリビルダのDB::rawで対応
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        // キャンセル分を合計から除外する
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        // havingはgroupBy後の検索
        ->having('event_id',$event->id)
        ->first();

        // 予約者がnullでなければ
        if(!is_null($reservedPeople))
        {
            // 予約可能な人数 = 最大定員 - 予約済みの人数 (キャンセルを除く)
            $resevablePeople = $event->max_people - $reservedPeople->number_of_people;
        }
        else {
            $resevablePeople = $event->max_people;
        }

        // eventIDと予約可能人数を詳細ページに渡す
        return \view('event-detail',\compact('event','resevablePeople'));
    }
}
