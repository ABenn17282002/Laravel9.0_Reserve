<?php

namespace App\Http\Livewire;

use Livewire\Component;
// User・Hashモデルの使用
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $register;

    // formの値を格納する変数
    public $name;
    public $email;
    public $password;

    // validation
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ];

    // リアルタイムバリデーション
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    // 登録処理
    public function register()
    {
        $this->validate();
        // dd($this);

        // DBへ登録
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // 登録完了のflash-message
        \session()->flash('message','登録OKです');
        // livewire-test.indexへリダイレクト
        return \to_route('livewire-test.index');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
