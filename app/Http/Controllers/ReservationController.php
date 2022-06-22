<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return \view('dashboard');
    }

    public function detail($id)
    {
        // eventIDを取得
        $event = Event::findOrFail($id);
        // eventIDを詳細ページに渡す
        return \view('event-detail',\compact('event'));
    }
}
