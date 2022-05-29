<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
// DBファザード
use Illuminate\Support\Facades\DB;
// 日付取得モジュール
use Carbon\Carbon;
// EventServiceモジュール
use App\Services\EventService;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 本日日付の取得
        $today = Carbon::today();

        /* 予約人数の確認
        *  SQL:SELECT `event_id`,
        *  sum(`number_of_people`) FROM
        *  `reservations` GROUP by `event_id` */
        $reservedPeople = DB::table('reservations')
        // select内でsumを使うため、クエリビルダのDB::rawで対応
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->groupBy('event_id');

        // 今日以降を日付順に10件ずつ取得
        $events = DB::table('events')
        // 外部結合:合計人数がない場合、nullとして表示される
        ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
            $join->on('events.id','=', 'reservedPeople.event_id');
        })
        ->whereDate('start_date', '>=', $today) // 本日日付以降を取得
        ->orderBy('start_date', 'asc')
        ->paginate(10);

        // eventデータをindexページに渡す
        return view('manager.events.index',
        compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        // フォームから渡ってきた日付、開始時間、終了時間を渡す=>関数内で重複イベント確認
        $check = EventService::checkEventDuplication(
            $request['event_date'],$request['start_time'],$request['end_time']);

        // 重複の場合、アラートを出す
        if($check){
            session()->flash('alert', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
        }

        // 開始時間(日付作成処理はEventService::joinDateAndTime内)
        $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
        // 終了時間(日付作成処理はEventService::joinDateAndTime内)
        $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

        // DB保存処理
        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible']
        ]);

         // 登録完了のflash-message
        session()->flash('status', '登録okです');
        // event.indexへリダイレクト
        return to_route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        // dd($event);
        // イベントモデルを取得
        $event = Event::findorFail($event->id);

        // DBから取得したリレーション情報
        $users = $event->users;

        // dd($event, $users);

        // アクセサで日付、開始時間、終了時間を取得
        $eventDate = $event->eventDate;
        $startTime = $event->startTime ;
        $endTime = $event->endTime ;

        // 取得したイベント・User情報及び開始日時、終了時間を詳細ページへ返す
        return view('manager.events.show',\compact('event','users','eventDate','startTime','endTime'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        // イベントIDの取得
        $event = Event::findorFail($event->id);

        // 日付を元のY-m-d形式に戻したものを挿入する
        $eventDate = $event->editEventDate;
        $startTime = $event->startTime ;
        $endTime = $event->endTime ;

        return view('manager.events.edit',
        \compact('event','eventDate','startTime','endTime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        // 重複イベントをカウントする
        $check = EventService::checkEventDuplicationExceptOwn(
            // イベント自身のIDも渡す
            $event->id,
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        // dd($check);

        // 重複の場合、アラートを出す
        if($check){
            $event = Event::findorFail($event->id);

            // Accessor
            $eventDate = $event->editEventDate;
            $startTime = $event->startTime ;
            $endTime = $event->endTime ;

            session()->flash('alert', 'この時間帯は既に他の予約が存在します。');

            return view('manager.events.edit',
            \compact('event','eventDate','startTime','endTime'));
        }

        // 開始時間(日付作成処理はEventService::joinDateAndTime内)
        $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
        // 終了時間(日付作成処理はEventService::joinDateAndTime内)
        $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

        // イベントIDを取得
        $event = Event::findorFail($event->id);
        // 取得したイベントIDから情報を取得
        $event->name = $request['event_name'];
        $event->information = $request['information'];
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request['max_people'];
        $event->is_visible = $request['is_visible'];
        // 編集したイベント情報を保存
        $event->save();

         // 登録完了のflash-message
        session()->flash('status', '更新完了しました');
        // event.indexへリダイレクト
        return to_route('events.index');
    }

    // 過去のイベント一覧表示
    public function past()
    {
        // 現在日時の取得
        $today = Carbon::today();

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->groupBy('event_id');

        // 開始日時を本日以前のものを降順に取得
        $events = DB::table('events')
        // 外部結合
        ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
            $join->on('events.id','=', 'reservedPeople.event_id');
        })
        ->whereDate('start_date', '<', $today)
        ->orderBy('start_date','desc')
        ->paginate(10);

        // 取得したイベント情報及を過去ページへ返す
        return view('manager.events.past',\compact('events'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
