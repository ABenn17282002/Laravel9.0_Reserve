<div style="text-align: center">
    {{-- wire:click=“メソッド名”で実行 --}}
    <button wire:click="increment">+</button>
    {{-- Counterクラス内プロパティを表示 --}}
    <h1>{{ $count }}</h1>
    {{-- 指定ms待って通信 1000ms = 1秒 --}}
    <input wire:model.debounce.2000="name1" type="text"><br>
    こんにちは {{ $name1 }} さん<br>

    {{-- フォーカスが外れたタイミングで通信
    (JSのchangeイベント) --}}
    <input wire:model.lazy="name2" type="text"><br>
    こんにちは {{ $name2 }} さん<br>
    <button wire:mouseover="mouseOver">マウスを合わせてね</button><br>

    <br>

    {{-- submitボタンなどを押したタイミングで通信--}}
    <input wire:model.defer="name3" type="text"><br>
    こんにちは {{ $name3 }} さん<br>
</div>
