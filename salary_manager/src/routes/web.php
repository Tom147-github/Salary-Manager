<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [SalaryController::class, 'showWelcome']);
Route::post('/result', [SalaryController::class, 'updateResult'])->name('update.result');
Route::post('/reset', [SalaryController::class, 'resetSalaryTable'])->name('reset.salary.table');