<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rest;
use App\Models\Attend;

class RestController extends Controller
{
    public function restStart()
{
    $latestAttend = Attend::where('user_id', Auth::id())->latest('created_at')->pluck('id')->first();

    if ($latestAttend) {
        $existingRest = Rest::where('attend_id', $latestAttend)->whereNull('rest_end')->exists();

        if ($existingRest) {
            return redirect()->route('stamp')->with('error', '既に休憩が開始されています');
        }
    } else {
        // 出勤情報が見つからない場合
        return redirect()->route('stamp')->with('error', '出勤していないため、休憩を開始できません');
    }

    $dates = new Rest;
    $dates->attend_id = $latestAttend;
    $dates->rest_start = now();
    $dates->save();

    return redirect()->route('stamp')->with('success', '休憩開始しました');
}



    public function restEnd()
    {
        $latestAttend = Attend::where('user_id', Auth::id())->latest('created_at')->pluck('id')->first();

        $rest = Rest::where('attend_id', $latestAttend)->latest()->first();
        if ($rest) {
            if ($rest->rest_end) {
                return redirect()->route('stamp')->with('error', '既に休憩が終了しています');
            }

            $rest->rest_end = now();
            $rest->save();

            return redirect()->route('stamp')->with('success', '休憩終了しました');
        } else {
            return redirect()->route('stamp')->with('error', '休憩開始情報が見つかりません');
        }
    }

}
