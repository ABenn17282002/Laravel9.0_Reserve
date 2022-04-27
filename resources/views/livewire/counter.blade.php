<div style="text-align: center">
    {{-- wire:click=“メソッド名”で実行 --}}
    <button wire:click="increment">+</button>
    {{-- Counterクラス内プロパティを表示 --}}
    <h1>{{ $count }}</h1>
</div>
