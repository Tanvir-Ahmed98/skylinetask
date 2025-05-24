<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\BudgetController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('expenses', ExpenseController::class);
    Route::get('budget',    [BudgetController::class, 'show']);
    Route::post('budget',   [BudgetController::class, 'update']);
    Route::post('logout',   [AuthController::class, 'logout']);
});
