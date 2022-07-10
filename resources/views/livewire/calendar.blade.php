<div>
    <div class="text-center text-sm">
        日付を選択してください。本日から最大30日先まで選択可能です。
    </div>
    <input id="calendar" class="block mt-1 mb-2 mx-auto" type="text" name="calendar" {{-- datepickerで変更したら値も変更する --}}
        value="{{ $currentDate }}" wire:change="getDate($event.target.value)" />

    <div class="flex mx-auto">
        <x-calendar-time />
        {{-- 日付と曜日 --}}
        @for($i = 0; $i < 7; $i++) <div class="w-32">
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['day'] }}</div>
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div>
            {{-- 時間 --}}
            @for($j = 0; $j < 21; $j++) {{-- イベントがあれば表示 --}} @if($events->isNotEmpty())
                {{-- イベント開始時間(DB) = 対象時間(入力した日付+時間)の場合、イベント名を表示 --}}
                @if(!is_null($events->firstWhere('start_date',
                $currentWeek[$i]['checkDay'] . " " . \Constant::EVENT_TIME[$j] )))
                @php
                // eventIdを取得
                $eventId = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " .
                \Constant::EVENT_TIME[$j])->id;
                // event名の取得
                $eventName = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " .
                \Constant::EVENT_TIME[$j] )->name;
                // 開始・終了時間取得のためのオブジェクト
                $eventInfo = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " .
                \Constant::EVENT_TIME[$j] );
                // 開始時間 - 終了時間の差分を計算
                $eventPeriod = \Carbon\Carbon::parse($eventInfo->start_date)->diffInMinutes($eventInfo->end_date) / 30 -
                1;
                // 予約可能人数 = 定員 - 予約済み人数
                $resevablePeople = $eventInfo->max_people - $eventInfo->number_of_people;
                // dd($eventInfo);
                @endphp
                {{-- 予約可能な場合:blue,予約可能人数表示 --}}
                @if($resevablePeople > 0)
                <a href="{{ route('events.detail', ['id' => $eventId ]) }}">
                    {{-- イベント名の記載 --}}
                    <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">
                        {{ $eventName }} <br>{{ $resevablePeople }}人
                    </div>
                </a>
                {{-- イベント時間が0以上なら色を塗って表示 --}}
                @if( $eventPeriod > 0 )
                @for($k = 0; $k < $eventPeriod ; $k++) <div class="py-1 px-2 h-8 border border-gray-200 bg-blue-100">
    </div>
    @endfor
    {{-- 追加した分$j(縦列のマス目)も増やす --}}
    @php $j += $eventPeriod @endphp
    @endif
    {{-- 満員時:Gray --}}
    @else
    <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-gray-200">
        {{ $eventName }}
    </div>
    @if( $eventPeriod > 0 )
    @for($k = 0; $k < $eventPeriod ; $k++) <div class="py-1 px-2 h-8 border border-gray-200 bg-gray-200">
</div>
@endfor
{{-- 追加した分$j(縦列のマス目)も増やす --}}
@php $j += $eventPeriod @endphp
@endif
@endif
@else
<div class="py-1 px-2 h-8 border border-gray-200"></div>
@endif
@else
<div class="py-1 px-2 h-8 border border-gray-200"></div>
@endif
@endfor
</div>
@endfor
</div>
</div>
