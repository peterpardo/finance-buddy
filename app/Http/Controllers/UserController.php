<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $scripts = [
            asset('js/user/income-pie.js'),
            asset('js/user/expense-pie.js'),
            asset('js/user/add-finance.js'),
        ];

        return view('index', [
            'scripts' => $scripts,
        ]);
    }

    public function incomePage($id) {
        $user = User::find($id);
        $finances = $user->finance()->where('type', 'income')->get();
        
        $scripts = [
            asset('js/user/income-pie.js'),
            asset('js/user/delete-finance.js'),
        ];

        return view('user.finance-details', [
            'title' => 'My Income',
            'scripts' => $scripts,
            'finances' => $finances
        ]);
    }

    public function expensePage($id) {
        $user = User::find($id);
        $finances = $user->finance()->where('type', 'expense')->get();
        
        $scripts = [
            asset('js/user/expense-pie.js'),
        ];

        return view('user.finance-details', [
            'title' => 'My Expenses',
            'scripts' => $scripts,
            'finances' => $finances
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

    public function fetchIncomeLogs($id) {
        $user = User::find($id);
        $finances = $user->finance()->orderBy('created_at', 'desc')->where('type', 'income')->get();
        $categories = $user->finance()->select('category')->where('type', 'income')->distinct()->get();

        return [
            $finances,
            $categories,
        ];
    }

    public function deleteFinance($id) {
        Finance::destroy($id);
        
        return response([
            'success' => 'Record successfully deleted.'
        ]);
    }

    public function fetchLogs($id) {
        $user = User::find($id);
        $finances = $user->finance()->orderBy('created_at', 'desc')->get();

        return $finances;
    }

    public function fetchIncomePie($id) {
        $user = User::find($id);
        $categories = $user->finance()->select('category', 'amount')->where('type', 'income')->distinct()->get();
        return $categories;
    }

    public function fetchExpensePie($id) {
        $user = User::find($id);
        $categories = $user->finance()->select('category', 'amount')->where('type', 'expense')->distinct()->get();
        return $categories;
    }

    // Reminder Page
    public function reminderPage() {
        return view('user.reminder-page');
    }

    public function setReminder(Request $request) {
        dd($request->all());
    }



    // Test Functions
    public function piePage() {
        return view('test.pie', [
            'script' => asset('js/test/pie.js'),
        ]);
    } 
    public function fetchCategories($id) {
        $user = User::find($id);
        $categories = $user->finance()->select('category', 'amount')->where('type', 'expense')->distinct()->get();
        return $categories;
    }
    public function smsPage() {
        $basic  = new \Vonage\Client\Credentials\Basic("9b6de49c", "OGQVQ2BqfR1F4y32");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("639453175950", 'CYBER ACE', 'Yow, meron kang utang master, bayaran mo na')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

    }
    public function send(Request $request) {
      
    }
}
