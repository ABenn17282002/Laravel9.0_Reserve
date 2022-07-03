<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約済みのイベント一覧
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        {{-- flassmessageの表示 --}}
                        <x-flash-message/>

                        <div class="w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">イベント名</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fromTodayEvents as $event)
                                    <tr>
                                        {{-- イベント名 --}}
                                        <td class="text-blue-500 px-4 py-3">
                                        {{-- 詳細画面へのリンク作成
                                        前回:Collection($event->id),今回は連想配列($event['id'])--}}
                                        <a href="{{ route('mypage.show',['id'=>$event['id']] )}}">
                                            {{ $event['name'] }}
                                        </a>
                                        </td>
                                        {{-- 開始日時 --}}
                                        <td class="px-4 py-3">{{ $event['start_date'] }}</td>
                                        {{-- 終了日時 --}}
                                        <td class="px-4 py-3">{{ $event['end_date'] }}</td>
                                        {{-- 予約人数 --}}
                                        <td class="px-4 py-3"> {{ $event['number_of_people'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-center py-2">過去のイベント一覧</h2>
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        {{-- flassmessageの表示 --}}
                        <x-flash-message/>

                        <div class="w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">イベント名</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pastEvents as $event)
                                    <tr>
                                        {{-- イベント名 --}}
                                        <td class="text-blue-500 px-4 py-3">
                                        {{-- 詳細画面へのリンク作成
                                        前回:Collection($event->id),今回は連想配列($event['id'])--}}
                                        <a href="{{ route('mypage.show',['id'=>$event['id']] )}}">
                                            {{ $event['name'] }}
                                        </a>
                                        </td>
                                        {{-- 開始日時 --}}
                                        <td class="px-4 py-3">{{ $event['start_date'] }}</td>
                                        {{-- 終了日時 --}}
                                        <td class="px-4 py-3">{{ $event['end_date'] }}</td>
                                        {{-- 予約人数 --}}
                                        <td class="px-4 py-3"> {{ $event['number_of_people'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
