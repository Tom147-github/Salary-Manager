<?php

namespace App\Http\Controllers;

use App\Models\DayAndSalaryAmount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function showWelcome()
    {
        return view('welcome');
    }

    public function updateResult(Request $request)
    {
        //入力された日付のデータがDBに存在しない場合は新規作成し、存在する場合は上書き
        DayAndSalaryAmount::query()->updateOrCreate(
            ['day' => $request->get("day")],
            ['amount' => $request->get("amount")]
        );

        /*
         * ・DBに登録された１日から３１日までのそれぞれの日の金額を、日付をキーとして取得し、配列を生成
         * ・対象の日付のデータが存在しない場合はnullが格納される
         */
        $day_amounts = DayAndSalaryAmount::query()
            ->select(['amount', 'day'])
            ->orderBy('day')
            ->get();
        $amounts = [];
        $today = Carbon::today();
        for ($day = 1; $day <= $today->endOfMonth(); $day++) {
            $amounts[$day] = $day_amounts->where('day', '=', $day)
                ->pluck('amount')
                ->first();
        }

        //Tableに表示されている全ての金額を合計し、変数に格納
        $total_amount = 0;
        foreach ($amounts as $amount) {
            $total_amount += $amount;
        }

        $eom = Carbon::today();
        return view('result', compact('amounts', 'total_amount', "eom"));
    }

    public function resetSalaryTable()
    {
        //DBリセット
        DayAndSalaryAmount::query()->delete();

        //Tableリセット
        $amounts = [];
        $today = Carbon::today();
        for ($day = 1; $day <= $today->endOfMonth(); $day++) {
            $amounts[$day] = null;
        }

        //合計金額リセット
        $total_amount = 0;
        $eom = Carbon::today();
        return view('result', compact('amounts', 'total_amount', "eom"));
    }
}
