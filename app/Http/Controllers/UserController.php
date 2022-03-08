<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        return view('index', [
            'script' => asset('js/user/add-finance.js')
        ]);
    }

    public function incomePage() {
        return view('user.finance-details', [
            'title' => 'My Income',
        ]);
    }

    public function expensePage() {
        return view('user.finance-details', [
            'title' => 'My Expenses',
        ]);
    }

    // Create Income or Expense
    public function addFinance(Request $request) {
        $user = User::find(Auth::user()->id);
        
        $user->finance()->create([
            'type' => $request->typeValue,
            'category' => $request->categoryValue,
            'amount' => $request->amountValue,
            'description' => $request->descriptionValue,
        ]);
        
        return response([
            'success' => 'Schedule successfully created.'
        ]);
    }

}
