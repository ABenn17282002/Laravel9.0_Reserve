<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public $name1="";

    public $name2="";

    public $name3="";

    // 描画実行前処理
    public function mount()
    {
        $this->name2 = 'mount';
    }

    // データ更新毎
    public function updated()
    {
        $this->name2 = 'updated';
    }

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
