<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attend;


class AttendController extends Controller
{
    public function attendStart()
    {
        $existingAttend = Attend::where('user_id', Auth::id())->whereNull('attend_end')->exists();

        if ($existingAttend) {
            return redirect()->route('stamp')->with('error', '既に出勤されています');
        }

        $dates = new Attend;
        $dates->user_id = Auth::id();
        $dates->attend_start = now();
        $dates->save();

        return redirect()->route('stamp')->with('success', '出勤しました');
    }

    public function attendEnd()
    {
        $attend = Attend::where('user_id', Auth::id())->latest()->first();

        if ($attend) {
            if ($attend->attend_end) {
                return redirect()->route('stamp')->with('error', '既に退勤されています');
            }

            $attend->attend_end = now();
            $attend->save();

            return redirect()->route('stamp')->with('success', '退勤しました');
        } else {
            return redirect()->route('stamp')->with('error', '出勤情報が見つかりません');
        }
    }
}
