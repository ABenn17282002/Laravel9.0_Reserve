<div>
    <div class="text-center text-sm">
        日付を選択してください。本日から最大30日先まで選択可能です。
    </div>
    <x-jet-input id="calendar" class="block mt-1 mb-2 mx-auto" type="text" name="calendar"
    {{-- datepickerで変更したら値も変更する --}}
    value="{{ $currentDate }}"
    wire:change="getDate($event.target.value)"/>

    <div class="flex border border-green-400 mx-auto">
        <x-calendar-time />
        @for($i = 0; $i < 7; $i++)
        <div class="w-32">
            {{-- 日付と曜日 --}}
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['day'] }}</div>
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div>
            @for($j = 0; $j < 21; $j++)
                {{-- 時間 --}}
                @if ($events->isNotEmpty())
                    {{-- イベント開始時間(DB) = 対象時間(入力した日付+時間)の場合、イベント名を表示 --}}
                    @if(!is_null($events->firstWhere('start_date',
                    $currentWeek[$i]['checkDay']. " ".\Constant::EVENT_TIME[$j] )))
                        @php
                            // event名の取得
                            $eventName =$events->firstWhere('start_date',$currentWeek[$i]['checkDay']." ".\Constant::EVENT_TIME[$j])->name;
                            // 開始・終了時間取得のためのオブジェクト
                            $eventInfo = $events->firstWhere('start_date',$currentWeek[$i]['checkDay']. " ".\Constant::EVENT_TIME[$j]);
                            // 開始時間 - 終了時間の差分を計算
                            $eventPeriod = \Carbon\Carbon::parse($eventInfo->start_date)->diffInMinutes($eventInfo->end_date) / 30;
                        @endphp
                        <div class="py-1 px-2 h-8 border text-xs">
                            {{--  イベント名を追記 --}}
                            {{ $eventName  }}
                        </div>
                        {{-- イベント時間が0以上なら色を塗って表示 --}}
                        @if($eventPeriod > 0)
                            @for($k = 0; $k < $eventPeriod; $k++)
                                <div class="py-1 px-2 h-8 border border-gray-200 bg-blue-100"></div>
                            @endfor
                            {{-- 追加した分$j(縦列のマス目)も増やす --}}
                            @php $j += $eventPeriod @endphp
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

