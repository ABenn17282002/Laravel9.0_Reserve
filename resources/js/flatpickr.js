// es modules are recommended, if available, especially for typescript
import flatpickr from "flatpickr";
// flatpickrの日本語化用モジュール
import { Japanese } from "flatpickr/dist/l10n/ja.js"

// Otherwise, selectors are also supported
flatpickr("#event_date", {
    "locale":Japanese, // 日本
    minDate:"today",   // 最少日時(今日)
    maxDate: new Date().fp_incr(30)  //今日から何日選択可能か
});

// top画面のカレンダー表示
flatpickr("#calendar", {
    "locale":Japanese, // 日本
    minDate:"today",   // 最少日時(今日)
    maxDate: new Date().fp_incr(30)  //今日から何日選択可能か
});

// 開始時間と終了時間の設定
const setting = {
    "locale": Japanese, // 日本語
    enableTime: true,   // 時間表示
    noCalendar: true,   // calender表示なし
    dateFormat: "H:i",  // ●時▲分表示
    time_24hr: true,    // 24時間表示
    minTime: "10:00",   // <開始>10:00
    maxTime: "20:00",   // <終了>20:00
    minuteIncrement:30  // 30分単位
  }

// 開始時間
flatpickr("#start_time", setting);
// 終了時間
flatpickr("#end_time", setting);

