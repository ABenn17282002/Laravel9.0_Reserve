<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント新規登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- イベント登録 --}}
                <input type="text" id="event_date">
            </div>
        </div>
    </div>
    {{-- flatpickrの読み込み --}}
    <script src="{{ mix('js/flatpickr.js')}}">
    </script>
</x-app-layout>
