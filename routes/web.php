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
    Route::get('/income/{id}', [UserController::class, 'incomePage']);
    Route::get('/expense/{id}', [UserController::class, 'expensePage']);

    Route::post('/add-finance', [UserController::class, 'addFinance']);
    Route::get('/fetch-income-pie/{id}', [UserController::class, 'fetchIncomePie']);
    Route::get('/fetch-expense-pie/{id}', [UserController::class, 'fetchExpensePie']);
    Route::get('/fetch-logs/{id}', [UserController::class, 'fetchLogs']);
    Route::get('/fetch-income-logs/{id}', [UserController::class, 'fetchIncomeLogs']);
    Route::post('/delete-finance/{id}', [UserController::class, 'deleteFinance']);
    Route::post('/edit-finance/{id}', [UserController::class, 'editFinance']);

    // Generate Records
    Route::get('/download-records', [UserController::class, 'downloadRecords']);

    // Set Reminder View
    Route::get('/set-reminder', [UserController::class, 'reminderPage']);
    Route::post('/set-reminder', [UserController::class, 'setReminder']);

    // Test Route
    Route::get('/pie', [UserController::class, 'piePage']);
    Route::get('/fetch-categories/{id}', [UserController::class, 'fetchCategories']);
    Route::get('/send-sms', [UserController::class, 'smsPage']);
    // Route::post('/send-sms', [UserController::class, 'send']);
});

