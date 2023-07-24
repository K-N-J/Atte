<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attend;
use App\Models\Rest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user()
    {
        $date = request()->query('date', date('Y-m-d'));
        $prev_date = Carbon::parse($date)->subDay()->toDateString();
        $next_date = Carbon::parse($date)->addDay()->toDateString();

        // 現在ログインしているユーザーのIDを取得
        $userId = Auth::id();

        $attends = User::select('users.name',
            'attends.attend_start', 'attends.attend_end', 'attends.created_at',
            DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(rests.rest_end) - TIME_TO_SEC(rests.rest_start))) AS rest_time'),
            DB::raw('SEC_TO_TIME(TIME_TO_SEC(attends.attend_end) - TIME_TO_SEC(attends.attend_start) - SUM(TIME_TO_SEC(CASE WHEN rests.rest_end IS NULL THEN 0 ELSE rests.rest_end END) - TIME_TO_SEC(CASE WHEN rests.rest_start IS NULL THEN 0 ELSE rests.rest_start END))) AS work_time'),
            DB::raw("DATE_FORMAT(attends.created_at, '%Y-%m-%d') as date"))
            ->join('attends', 'users.id', '=', 'attends.user_id')
            ->leftJoin('rests', 'attends.id', '=', 'rests.attend_id')
            ->where('users.id', $userId)
            ->whereDate('attends.created_at', $date)
            ->groupBy('users.name', 'attends.attend_start', 'attends.attend_end', 'attends.created_at', 'date')
            ->orderBy('date', 'desc')
            ->paginate(5, ['*'], 'page', request()->query('page'));

        $attends->appends(['date' => $date])->links();

        return view('user', compact('attends', 'prev_date', 'next_date', 'date'));
    }

    public function userDetails($userId)
    {
      $date = request()->query('date', date('Y-m-d'));
      $prev_date = Carbon::parse($date)->subDay()->toDateString();
      $next_date = Carbon::parse($date)->addDay()->toDateString();

      $attends = User::select('users.name',
          'attends.attend_start', 'attends.attend_end', 'attends.created_at',
          DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(rests.rest_end) - TIME_TO_SEC(rests.rest_start))) AS rest_time'),
          DB::raw('SEC_TO_TIME(TIME_TO_SEC(attends.attend_end) - TIME_TO_SEC(attends.attend_start) - SUM(TIME_TO_SEC(CASE WHEN rests.rest_end IS NULL THEN 0 ELSE rests.rest_end END) - TIME_TO_SEC(CASE WHEN rests.rest_start IS NULL THEN 0 ELSE rests.rest_start END))) AS work_time'),
          DB::raw("DATE_FORMAT(attends.created_at, '%Y-%m-%d') as date"))
          ->join('attends', 'users.id', '=', 'attends.user_id')
          ->leftJoin('rests', 'attends.id', '=', 'rests.attend_id')
          ->where('users.id', $userId)
          ->whereDate('attends.created_at', $date)
          ->groupBy('users.name', 'attends.attend_start', 'attends.attend_end', 'attends.created_at', 'date')
          ->orderBy('date', 'desc')
          ->paginate(5, ['*'], 'page', request()->query('page'));

      $attends->appends(['date' => $date, 'userId' => $userId])->links();

      return view('user', compact('attends', 'prev_date', 'next_date', 'date'));
    }

    public function attend(Request $request)
    {
        $userId = $request->user()->id;
        $currentDate = date('Y-m-d');

        $existingAttend = DB::table('attends')
            ->where('user_id', $userId)
            ->whereDate('created_at', $currentDate)
            ->exists();

        if ($existingAttend) {
            // 既に出勤済みの場合は何もしない
            return redirect()->back();
        }

        DB::table('attends')->insert([
            'user_id' => $userId,
            'attend_start' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->back();
    }

    public function rest(Request $request)
    {
        $userId = $request->user()->id;
        $currentDate = date('Y-m-d');

        $existingRest = DB::table('rests')
            ->where('user_id', $userId)
            ->whereDate('created_at', $currentDate)
            ->whereNull('rest_end')
            ->exists();

        if ($existingRest) {
            // 既に休憩中の場合は何もしない
            return redirect()->back();
        }

        DB::table('rests')->insert([
            'user_id' => $userId,
            'rest_start' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->back();
    }

    public function leave(Request $request)
    {
        $userId = $request->user()->id;
        $currentDate = date('Y-m-d');

        $existingRest = DB::table('rests')
            ->where('user_id', $userId)
            ->whereDate('created_at', $currentDate)
            ->whereNull('rest_end')
            ->exists();

        if ($existingRest) {
            // 休憩中の場合は休憩終了時間を更新
            DB::table('rests')
                ->where('user_id', $userId)
                ->whereDate('created_at', $currentDate)
                ->whereNull('rest_end')
                ->update([
                    'rest_end' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }

        // 出勤終了時間を更新
        DB::table('attends')
            ->where('user_id', $userId)
            ->whereDate('created_at', $currentDate)
            ->update([
                'attend_end' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return redirect()->back();
    }
}
