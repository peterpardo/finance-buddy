<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function() {
    // Home Route
    Route::get('/', [UserController::class, 'index'])->name('home');

    // Income and Expense View
    Route::get('/income', [UserController::class, 'incomePage']);
    Route::get('/expense', [UserController::class, 'expensePage']);

    Route::post('/add-finance', [UserController::class, 'addFinance']);
});

