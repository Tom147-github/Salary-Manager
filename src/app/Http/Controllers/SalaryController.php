<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DayAndSalaryAmount;

class SalaryController extends Controller
{
    public function showWelcome()
    {
        return view('welcome');
    }

    public function updateResult(Request $request)
    {
        //入力された日付のデータがDBに存在しない場合は新規作成し、存在する場合は上書き
        DayAndSalaryAmount::updateOrCreate(
            [ 'day' => $request->get("day") ],
            [ 'amount' => $request->get("amount") ]
        );

        /*
         * ・DBに登録された１日から３１日までのそれぞれの日の金額を、日付をキーとして取得し、配列を生成
         * ・対象の日付のデータが存在しない場合はnullが格納される
         */
        $day_amount_data = DayAndSalaryAmount::query()
                                             ->select(['amount', 'day'])
                                             ->orderBy('day')
                                             ->get();
        $amounts = [];
        for ($day = 1; $day <= 31; $day++) {
            $amounts[$day] = $day_amount_data->where('day', '=', $day)
                                             ->pluck('amount')
                                             ->first();
        }

        //Tableに表示されている全ての金額を合計し、変数に格納
        $total_amount = 0;
        foreach ($amounts as $amount) {
            $total_amount += $amount;
        }

        return view('result', compact('amounts', 'total_amount'));
    }

    public function resetSalaryTable()
    {
        //DBリセット
        $all_day_amount_data = DayAndSalaryAmount::all();
        $all_day_amount_data->each->delete();

        //Tableリセット
        $amounts = [];
        for ($day = 1; $day <= 31; $day++) {
            $amounts[$day] = null;
        }

        //合計金額リセット
        $total_amount = 0;

        return view('result', compact('amounts', 'total_amount'));
    }
}