<?php

use Illuminate\Support\Facades\Route;
// Livewire用コントローラ
use App\Http\Controllers\LivewireTestController;
// AlpineTest用コントローラ
use App\Http\Controllers\AlpineTestController;
// EventContrller
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('calendar');
});

// manager以上の権限がアクセス可
Route::prefix('manager')
->middleware('can:manager-higher')->group(function(){
    // 過去ページはresouceの上で定義する。
    Route::get('events/past', [EventController::class, 'past'])->name('events.past');
    // Event関連リソースの紐づけ
    Route::resource('events',EventController::class);
});

// user以上権限がアクセス可
Route::middleware('can:user-higher')->group(function(){
    Route::get('index', function () {
        dd('user');
    });
});

// alpine表示用ルートの設定
Route::get('alpine-test/index',
[AlpineTestController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Livewire用ルートの指定
Route::controller(LivewireTestController::class)
->prefix('livewire-test')->name('livewire-test.')->group(function(){
    Route::get('index', 'index')->name('index');
    // 登録用ルート設定
    Route::get('register', 'register')->name('register');
});
