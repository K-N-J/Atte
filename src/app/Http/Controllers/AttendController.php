<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attend;
use Carbon\Carbon;



class AttendController extends Controller
{
    public function attendStart(Request $request)
{
    // 当日の出勤データを取得
    $todayAttend = Attend::where('user_id', Auth::id())
        ->whereDate('attend_start', Carbon::today())
        ->first();

    // 当日の出勤データが存在する場合はエラーを表示
    if ($todayAttend) {
        return redirect()->route('stamp')->with('error', '既に出勤されています');
    }

    // 退勤していないレコードがあるかを確認
    $existingUnfinishedAttend = Attend::where('user_id', Auth::id())
        ->whereDate('attend_start', Carbon::today())
        ->whereNotNull('attend_start')
        ->whereNull('attend_end')
        ->exists();

    if ($existingUnfinishedAttend) {
        return redirect()->route('stamp')->with('error', 'まだ退勤していません');
    }

    $attend = new Attend;
    $attend->user_id = Auth::id();
    $attend->attend_start = now();
    $attend->save();

    return redirect()->route('stamp')->with('success', '出勤しました');
}


    public function attendEnd(Request $request)
{
    // 当日の最新の出勤データを取得
    $attend = Attend::where('user_id', Auth::id())
        ->whereDate('attend_start', Carbon::today())
        ->latest()
        ->first();

    if ($attend) {
        if ($attend->attend_end) {
            // 既に退勤済みの場合にエラーを表示
            return redirect()->route('stamp')->with('error', '既に退勤されています');
        }

        // 出勤がされているかを確認
        if (!$attend->attend_start) {
            return redirect()->route('stamp')->with('error', '出勤情報が見つかりません');
        }

        $attend->attend_end = now();
        $attend->save();

        return redirect()->route('stamp')->with('success', '退勤しました');
    } else {
        // 出勤データが見つからない場合にエラーを表示
        return redirect()->route('stamp')->with('error', '退勤情報が見つかりません');
    }
}


}
