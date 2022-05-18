<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
// DBファザード
use Illuminate\Support\Facades\DB;
// 日付取得モジュール
use Carbon\Carbon;

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
        // dd($request);

        /** <登録時間重複確認>
         * 新規の開始時間  < 登録済みの終了時間
         * and
         * 新規の終了時間 > 登録済みの開始時間
         * 例) 登録済み  A 10:00 - 12:00, B 13:00 - 15:00
         * 新規 11:00-14:00 ＝> 11:00-12:00と13:00-14:00まで重複NG
         */
        $check = DB::table('events')
        ->whereDate('start_date', $request['event_date'])  // 日時
        ->whereTime('end_date' ,'>',$request['start_time'])
        ->whereTime('start_date', '<', $request['end_time'])
        ->exists(); // 存在確認

        // dd($check);

        // 重複の場合、アラートを出す
        if($check){
            session()->flash('alert', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
        }

        // 開始時間=日時+開始時間→CarbonLibraryで日付にフォーマット
        $start = $request['event_date'] . " " . $request['start_time'];
        $startDate = Carbon::createFromFormat('Y-m-d H:i', $start);

        // 終了時間=日時+終了時間→CarbonLibraryで日付にフォーマット
        $end = $request['event_date'] . " " . $request['end_time'];
        $endDate = Carbon::createFromFormat('Y-m-d H:i', $end);

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
