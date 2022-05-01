<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivewireTestController extends Controller
{

    // 登録用ページ
    public function register()
    {
        return view('livewire-test.register');
    }

    public function index()
    {
        // Live-wire用ページの表示
        return view('livewire-test.index');
    }
}
