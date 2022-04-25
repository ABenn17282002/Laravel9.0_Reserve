<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivewireTestController extends Controller
{
    public function index()
    {
        // Live-wire用ページの表示
        return view('livewire-test.index');
    }
}
