<html>
    <head>
        {{-- LiveWire使用のためのlayouts設定 --}}
        @livewireStyles
    </head>
    <body>
        Live-WireTestです!
        {{-- Live-wireのカウンター --}}
        {{-- <livewire:counter /> --}}
        @livewire('counter')

        @livewireScripts
    </body>
</html>
