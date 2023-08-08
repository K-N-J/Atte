<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rest;
use App\Models\Attend;
use Carbon\Carbon;

class RestController extends Controller
{

    private $working = false; //勤務中かどうかを示すフラグ

    public function restStart()
    {
        if (!$this->working){
            return redirect()->route('stamp')->with('error', 'この操作は勤務中のみ実行可能です');
        }

        $rest = Rest::where('attend_id', Auth::id())->orderBy('id', 'desc')->first();

        //すでに開始された休憩がある場合
        if($rest && !$rest->rest_end){
            return redirect()->route('stamp')->with('error', '休憩を開始できませんでした');
        }

        $newRest = new Rest;
        $newRest->attend_id = Auth::id();
        $newRest->rest_start = Carbon::now();
        $newRest->save();

        return redirect()->route('stamp')->with('success','休憩を開始しました');
    }

    public function restEnd(Request $request)
    {
        if (!$this->working){
            return redirect()->route('stamp')->with('error', 'この操作は勤務中のみ実行可能です');
        }

        $rest = Rest::where('attend_id', Auth::id())->orderBy('id', 'desc')->first();

        //休憩が開始されていない場合
        if(!$rest || $rest->rest_end){
            return redirect()->route('stamp')->with('error', '休憩を終了できませんでした');
        }

        $rest->rest_end = Carbon::now();
        $rest->save();

        return redirect()->route('stamp')->with('success', '休憩を終了しました');
    }

    public function __construct()
    {
        //コンストラクターで勤務中かどうかを設定する
        $this->middleware(function ($request, $next){
            $this->working = $this->working();
            return $next($request);
        });
    }

    private function working()
    {
        $userID = Auth::id();
        $today = Carbon::now()->toDateString();

        $attend = Attend::where('user_id', $userID)
        ->whereDate('created_at', $today)
        ->whereNull('attend_end')
        ->first();

        return $attend ? true : false;
    }
}