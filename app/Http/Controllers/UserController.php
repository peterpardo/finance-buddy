<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index() {
        // Get user records
        $user = User::find(Auth::user()->id);
        $finances = $user->finance()->orderBy('created_at', 'desc')->get(); 
        
        $scripts = [
            asset('js/user/income-pie.js'),
            asset('js/user/expense-pie.js'),
            asset('js/user/add-finance.js'),
        ];

        return view('index', [
            'scripts' => $scripts,
            'finances' => $finances,
            'totalIncome' => $finances->where('type', 'income')->sum('amount'),
            'totalExpense' => $finances->where('type', 'expense')->sum('amount'),
        ]);
    }

    public function incomePage($id) {
        $user = User::find($id);
        $finances = $user->finance()->where('type', 'income')->get();
        $categories = $user->finance()->select('category')->where('type', 'income')->distinct()->pluck('category');
        
        $scripts = [
            asset('js/user/income-pie.js'),
        ];

        return view('user.finance-details', [
            'title' => 'My Income',
            'scripts' => $scripts,
            'finances' => $finances,
            'categories' => $categories
        ]);
    }

    public function expensePage($id) {
        $user = User::find($id);
        $finances = $user->finance()->where('type', 'expense')->get();
        $categories = $user->finance()->select('category')->where('type', 'expense')->distinct()->pluck('category');;
        
        $scripts = [
            asset('js/user/expense-pie.js'),
        ];

        return view('user.finance-details', [
            'title' => 'My Expenses',
            'scripts' => $scripts,
            'finances' => $finances,
            'categories' => $categories
        ]);
    }

    // Create Income or Expense
    public function addFinance(Request $request) {
        $user = User::find(Auth::user()->id);
        
        $user->finance()->create([
            'type' => $request->type,
            'category' => Str::title(trim($request->category)),
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        
        return back()->with('success', 'Record successfully created.');
    }

    public function deleteFinance($id) {
        // Delete record
        Finance::destroy($id);
        
        return back()->with('success', 'Record successfully deleted');
    }

    public function fetchLogs($id) {
        $user = User::find($id);
        $finances = $user->finance()->orderBy('created_at', 'desc')->get();

        return $finances;
    }

    public function fetchIncomePie($id) {
        $user = User::find($id);
        $finances = $user->finance()->where('type', 'income')->get();

        // Get Data for Pie Chart
        $data = [];
        foreach($finances as $finance) {
            if(!array_key_exists($finance->category, $data)) {
                $data[$finance->category] = $finance->amount; 
            } else {
                $data[$finance->category] = $data[$finance->category] + $finance->amount;
            }
        }

        return $data;
    }

    public function fetchExpensePie($id) {
        $user = User::find($id);
        $finances = $user->finance()->where('type', 'expense')->get();

        // Get Data for Pie Chart
        $data = [];
        foreach($finances as $finance) {
            // $string = str_replace(' ', '_', $finance->category);
            if(!array_key_exists($finance->category, $data)) {
                // echo 'Unique: ' . $finance->category;
                $data[$finance->category] = $finance->amount; 
            } else {
                // echo $finance->category . 'already exists.';
                $data[$finance->category] = $data[$finance->category] + $finance->amount;
            }
        }

        return $data;
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
