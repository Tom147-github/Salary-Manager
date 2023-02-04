<?php

namespace App\Http\Controllers;

use App\Models\DayAndSalaryAmount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryController extends Controller
{
    public function showWelcome(Request $request): View
    {
        return view('welcome');
    }

    public function updateResult(Request $request): View
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
        $total_amount = DayAndSalaryAmount::query()
            ->selectRaw("SUM(amount) AS total")
            ->orderBy('day')
            ->first()
            ->total;

        $amounts = collect();
        $today = Carbon::today();
        $eom = $today->endOfMonth()->day;

        foreach (range(1, $eom) as $day) {
            $filtered = $day_amounts->filter(function ($value, $key) use ($day) {
                return $value->day === $day;
            })->first();

            $salary = $filtered ?? new DayAndSalaryAmount([
                    "day" => $day,
                    "amount" => 0
                ]);
            $amounts->add($salary);
        }
        return view('result', compact('amounts', 'total_amount', "eom"));
    }

    public function resetSalaryTable(Request $request): View
    {
        //DBリセット
        DayAndSalaryAmount::query()->delete();

        //Tableリセット
        $amounts = collect();
        $today = Carbon::today();
        $eom = $today->endOfMonth()->day;

        foreach (range(1, $eom) as $day) {
            $salary = new DayAndSalaryAmount([
                "day" => $day,
                "amount" => 0
            ]);
            $amounts->add($salary);
        }

        //合計金額リセット
        $total_amount = 0;
        return view('result', compact('amounts', 'total_amount', "eom"));
    }
}
