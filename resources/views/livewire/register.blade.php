<div>
    {{-- ページ読み込み防止処理 --}}
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input id="name" type="text" wire:model="name"><br>
        {{-- 要:npm run watch or dev/prod --}}
        @error('name')<div class="text-red-400">{{ $message }}</div> @enderror

        <label for="email">メールアドレス</label>
        <input id="email" type="email" wire:model="email"><br>
        @error('email')<div class="text-red-400">{{ $message }}</div> @enderror

        <label for="password">パスワード</label>
        <input id="password" type="password" wire:model="password"><br>
        @error('password')<div class="text-red-400">{{ $message }}</div> @enderror
        <button>登録</button>
    </form>
</div>
