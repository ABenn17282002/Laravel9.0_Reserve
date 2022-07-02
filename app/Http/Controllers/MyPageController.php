<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// User
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\MyPageService;

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

        dd($events,$fromTodayEvents,$pastEvents);

        return \view('mypage/index',\compact('fromTodayEvents','pastEvents'));
    }
}
