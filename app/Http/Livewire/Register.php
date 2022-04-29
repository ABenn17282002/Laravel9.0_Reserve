<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Register extends Component
{
    // formの値を格納する変数
    public $name;
    public $email;
    public $password;

    public function register()
    {
        dd($this);
    }

    public function render()
    {
        return view('livewire.register');
    }
}
