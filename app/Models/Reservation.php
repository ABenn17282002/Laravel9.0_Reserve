<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // 中間テーブルの定義
    protected $fillable =[
        'user_id',  // user_id
        'event_id', // event_id
        'number_of_people' // 予約人数
    ];
}
