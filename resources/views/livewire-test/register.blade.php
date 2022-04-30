<html>
    <head>
    {{-- LiveWire使用のためのlayouts設定 + tailwidcss設定--}}
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        Live-WireTestです! register
        @livewire('register')
        @livewireScripts
    </body>
</html>
