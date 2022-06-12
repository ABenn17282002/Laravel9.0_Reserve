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
                    {{-- イベント開始時間(DB) = 対象時間(入力した日付+時間) --}}
                    @if(!is_null($events->firstWhere('start_date',$currentWeek[$i]['checkDay']. " ".\Constant::EVENT_TIME[$j] )))
                    <div class="py-1 px-2 h-8 border text-xs">
                        {{--  イベント名を追記 --}}
                        {{ $events->firstWhere('start_date',$currentWeek[$i]['checkDay']." ".\Constant::EVENT_TIME[$j])->name }}
                    </div>
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

