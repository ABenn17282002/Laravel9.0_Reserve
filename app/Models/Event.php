<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 属性アクセサ/ミューテタメソッドの使用を宣言
use Illuminate\Database\Eloquent\Casts\Attribute;
// 日付取得モジュール
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    // Event_tableの定義
    protected $fillable = [
        'name',         // イベント名
        'information',  // イベント情報
        'max_people',   // 定員
        'start_date',   // 開始時間
        'end_date',     // 終了時間
        'is_visible'    // 表示・非表示
    ];

    /* アクセサ(DB取得時にデータを加工する機能)　*/
    // 取得した開始日時から日付情報のみを取得
    protected function eventDate():Attribute
    {
        return new Attribute(get:fn()=>Carbon::parse($this->start_date)->format('Y年m月d日'));
    }

    // 取得した開始日時から開始時間のみを取得
    protected function startTime():Attribute
    {
        return new Attribute(get:fn()=>Carbon::parse($this->start_date)->format('H時i分'));
    }

    // 取得した終了日時から終了時間のみを取得
    protected function endTime():Attribute
    {
        return new Attribute(get:fn()=>Carbon::parse($this->end_date)->format('H時i分'));
    }
}
