<div>
    {{-- ページ読み込み防止処理 --}}
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input id="name" type="text" wire:model="name"><br>

        <label for="email">メールアドレス</label>
        <input id="email" type="email" wire:model="email"><br>

        <label for="password">パスワード</label>
        <input id="password" type="password" wire:model="password"><br>
        <button>登録</button>
    </form>
</div>
