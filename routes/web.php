<?php

use Illuminate\Support\Facades\Route;
// Livewire用コントローラ
use App\Http\Controllers\LivewireTestController;
// AlpineTest用コントローラ
use App\Http\Controllers\AlpineTestController;
// EventContrller
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
// MyPageController
use App\Http\Controllers\MyPageController;

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
Route::middleware('can:user-higher')
->group(function(){
    // dashboard
    Route::get('/dashboard',[ReservationController::class,'dashboard'])->name('dashboard');
    // MyPage.index
    Route::get('/mypage',[MyPageController::class,'index'])->name('mypage.index');
    // MyPage.show
    Route::get('/mypage/{id}',[MyPageController::class,'show'])->name('mypage.show');
    // MyPage.cancel
    Route::post('/mypage/{id}',[MyPageController::class,'cancel'])->name('mypage.cancel');
    // イベント詳細
    // Route::get('/{id}',[ReservationController::class,'detail'])->name('events.detail');
    // イベント予約
    Route::post('/{id}',[ReservationController::class,'reserve'])->name('events.reserve');
});

// 未ログイン時は、Loginフォームへ移動、Login時はイベント詳細画面
Route::middleware('auth')->get('/{id}', [ReservationController::class, 'detail'])->name('events.detail');

// alpine表示用ルートの設定
Route::get('alpine-test/index',
[AlpineTestController::class, 'index']);

// API認証を使用しない
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });


// Livewire用ルートの指定
Route::controller(LivewireTestController::class)
->prefix('livewire-test')->name('livewire-test.')->group(function(){
    Route::get('index', 'index')->name('index');
    // 登録用ルート設定
    Route::get('register', 'register')->name('register');
});
