<?php

namespace App\Http\Livewire;

use Livewire\Component;
// User・Hashモデルの使用
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
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
    }

    public function render()
    {
        return view('livewire.register');
    }
}
