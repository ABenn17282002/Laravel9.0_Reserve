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
        // eventsテーブルより降順に10ずつ件取得
        $events = DB::table('events')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
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
        //
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
