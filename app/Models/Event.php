<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
