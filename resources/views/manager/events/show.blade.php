<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- イベント登録フォーム --}}
                <div class="max-w-2xl py-4 mx-auto">
                    <x-jet-validation-errors class="mb-4" />
                    {{-- flassmessageの表示 --}}
                    <x-flash-message/>

                    <form method="get" action="{{ route('events.edit',['event'=> $event->id]) }}">
                        <div>
                            <x-jet-label for="event_name" value="イベント名" />
                            {{ $event->name }}
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="information" value="イベント詳細" />
                            {{--  e():エスケープ
                                　nl2br:改行を<br/>に変換
                                　{!! !!}:改行のみエスケープしない
                            --}}
                            {!!nl2br(e($event->information))!!}
                        </div>
                        <div class="md:flex justify-between">
                            <div class="mt-4">
                                <x-jet-label for="event_date" value="イベント日付" />
                                <x-jet-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" required />
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="start_time" value="開始時間" />
                                <x-jet-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" required/>
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="end_time" value="終了時間" />
                                <x-jet-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" required/>
                            </div>
                        </div>
                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-jet-label for="max_people" value="定員数" />
                                <x-jet-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" required/>
                            </div>
                            <div class="flex space-x-4 justify-around">
                                <input type="radio" name="is_visible" value="1" checked />表示
                                <input type="radio" name="is_visible" value="0" />非表示
                            </div>
                            <x-jet-button class="ml-4">
                                新規登録
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{-- flatpickrの読み込み --}}
<script src="{{ mix('js/flatpickr.js')}}"></script>
</x-app-layout>
