<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/profiles', [ProfileController::class, 'index']);
Route::post('/profiles', [ProfileController::class, 'store']);
Route::put('/profiles/{id}', [ProfileController::class, 'update']);
Route::delete('/profiles/{id}', [ProfileController::class, 'destroy']);

Route::get('/expenses', [ExpensesController::class, 'index']);
Route::post('/expenses', [ExpensesController::class, 'store']);
Route::put('/expenses/{id}', [ExpensesController::class, 'update']);
Route::delete('/expenses/{id}', [ExpensesController::class, 'destroy']);

Route::get('/incomes', [IncomeController::class, 'index']);
Route::post('/incomes', [IncomeController::class, 'store']);
Route::put('/incomes/{id}', [IncomeController::class, 'update']);
Route::delete('/incomes/{id}', [IncomeController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/monthly-reports', [MonthlyReportController::class, 'index']);
Route::get('/monthly-reports/{id}', [MonthlyReportController::class, 'show']);

Route::apiResource('budgets', BudgetController::class);
