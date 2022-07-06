<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
// DBファザード
use Illuminate\Support\Facades\DB;
// USER認証
use Illuminate\Support\Facades\Auth;
// Reservationモデル
use App\Models\Reservation;

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

        $isReserved = Reservation::where('user_id', '=', Auth::id())
        ->where('event_id', '=', $id)
        ->where('canceled_date', '=', null)
        ->latest()
        ->first();

        // 予約者がnullでなければ
        if(!is_null($reservedPeople))
        {
            // 予約可能な人数 = 最大定員 - 予約済みの人数 (キャンセルを除く)
            $resevablePeople = $event->max_people - $reservedPeople->number_of_people;
        }
        else {
            // nullの場合最大人数
            $resevablePeople = $event->max_people;
        }

        // eventIDと予約可能人数を詳細ページに渡す
        return \view('event-detail',\compact('event','resevablePeople','isReserved'));
    }

    public function reserve(Request $request)
    {
        // eventIDを取得
        $event = Event::findOrFail($request->id);

        /* Requestされたevent_idのキャンセル分を引いた予約人数を取得*/
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id', $request->id )
        ->first();

        // 予約者がいない or 最大定員 >= 予約人数 + 入力された人数の場合
        if(is_null($reservedPeople) ||
        $event->max_people >= $reservedPeople->number_of_people +$request->reserved_people)
        {
            // dd($reservedPeople->number_of_people,$request->reserved_people);
            //予約可能
            Reservation::create([
                'user_id'=>Auth::id(),
                'event_id'=> $request->id,
                'number_of_people'=>$request->reserved_people,
            ]);

            \session()->flash('status','予約を受け付けました。');
            return \to_route('dashboard');
        } else {
            // 定員オーバー
            \session()->flash('alert','この人数では予約できません。');
            return \to_route('dashboard');
        }
    }
}
