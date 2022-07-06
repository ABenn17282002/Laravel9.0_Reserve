<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// User
use App\Models\User;
// Event
use App\Models\Event;
// REservation
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Services\MyPageService;
use Carbon\Carbon;

class MyPageController extends Controller
{
    public function index(){
        // user情報の取得
        $user = User::findOrFail(Auth::id());
        // イベント一覧
        $events = $user->events;
        // 本日以降の予約
        $fromTodayEvents = MyPageService::reservedEvent($events,'fromToday');
        // 過去の予約
        $pastEvents = MyPageService::reservedEvent($events,'past');

        // dd($events,$fromTodayEvents,$pastEvents);

        return \view('mypage/index',\compact('fromTodayEvents','pastEvents'));
    }

    public function show($id)
    {
        // Eventidを取得
        $event = Event::findOrFail($id);
        // 予約取得(認証済IDかつEventID)
        $reservation = Reservation::where('user_id', '=', Auth::id())
        ->where('event_id', '=', $id)
        ->first();

        // dd($reservation);

        return \view('mypage/show',\compact('event','reservation'));
    }

    public function cancel($id)
    {
        // useridとeventidが合致するもの
        $reservation = Reservation::where('user_id','=', Auth::id())
        ->where('event_id', '=', $id)
        ->first();

        // キャンセル日を記載し、保存処理
        $reservation->canceled_date = Carbon::now()->format('Y-m-d H:i:s');
        $reservation->save();

        \session()->flash('status','キャンセルをしました');
        return \to_route('dashboard');
    }
}
