<?php

namespace App\Services;

// DBクラスとCarbonカレンダー
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MyPageService
{
    public static function reservedEvent($events, $string)
    {
        $reservedEvents = [];

        if($string == 'fromToday'){}

        if($string == 'past'){}

        return $reservedEvents;
    }
}
