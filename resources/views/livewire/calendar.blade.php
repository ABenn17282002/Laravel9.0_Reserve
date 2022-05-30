<div>
    カレンダー
    <x-jet-input id="calendar" class="block mt-1 w-full" type="text" name="calendar"
    {{-- datepickerで変更したら値も変更する --}}
    value="{{ $currentDate }}"
    wire:change="getDate($event.target.value)"/>
    {{ $currentDate }}
    <div class="flex">
        {{-- 日付の取得  --}}
        @for($day = 0; $day < 7; $day++)
            {{ $currentWeek[$day] }}
        @endfor
    </div>
</div>
