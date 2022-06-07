<div>
    <div class="text-center text-sm">
        日付を選択してください。本日から最大30日先まで選択可能です。
    </div>
    <x-jet-input id="calendar" class="block mt-1 mb-2 mx-auto" type="text" name="calendar"
    {{-- datepickerで変更したら値も変更する --}}
    value="{{ $currentDate }}"
    wire:change="getDate($event.target.value)"/>

    <div class="flex border border-green-400 mx-auto">
        <x-calendar-time /> <!-- コンポーネント作成 仮で直書き -->
        <x-day />
        <x-day />
        <x-day />
        <x-day />
        <x-day />
        <x-day />
        <x-day />
    </div>


    {{ $currentDate }}
    <div class="flex">
        {{-- 日付の取得  --}}
        @for($day = 0; $day < 7; $day++)
            {{ $currentWeek[$day] }}
        @endfor
    </div>
    @foreach ($events as $event)
        {{ $event->start_date }}<br>
    @endforeach
</div>
