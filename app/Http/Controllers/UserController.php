<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

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

    public function downloadRecords() {
        $user = User::find(Auth::user()->id);
        $data = [
            'incomes' => $user->finance()->orderBy('created_at', 'desc')->where('type', 'income')->get(),
            'expenses' => $user->finance()->orderBy('created_at', 'desc')->where('type', 'expense')->get(),
        ];

        $pdf = PDF::loadView('pdf.records', $data);
        return $pdf->download(time().'-my-records.pdf');
    }

    // Reminder Page
    public function reminderPage() {
        $user = User::find(Auth::user()->id);
        $reminders = $user->reminders()->orderBy('created_at', 'desc')->orderBy('sent', 'asc')->get();
        
        return view('user.reminder-page', [
            'reminders' => $reminders
        ]);
    }

    public function setReminder(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|size:10',
            'name' => 'required|string|max:10',
            'amount' => 'required|numeric|',
            'date' => 'required',       
        ]);

        // Validate date
        $date = Carbon::parse($request->date . "00:00:00", 'Asia/Manila');
        $dateValid = Carbon::today('Asia/Manila')->gte($date);

        $validator->after(function ($validator) use ($dateValid) {
            if ($dateValid) {
                $validator->errors()->add(
                    'date', 'Date should be set in advanced'
                );
            }
        });

        // Return if errors exists
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find(Auth::user()->id);
        $user->reminders()->create([
            'name' => Str::title($request->name),
            'number' => '63' . $request->phone_number,
            'amount' => $request->amount,
            'date' => $date,
        ]);

        return back()->with('success', 'Reminder successfully saved.');
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
        $user = User::find(Auth::user()->id);
        foreach($user->reminders()->get() as $reminder) {
            // Check date if it's due
            $date = Carbon::parse($reminder->date . "00:00:00", 'Asia/Manila');
            $isDue = Carbon::today('Asia/Manila')->lt($date);

            //  Send SMS if it's true
            if($isDue) {
                // $basic  = new \Vonage\Client\Credentials\Basic("9b6de49c", "OGQVQ2BqfR1F4y32");
                // $client = new \Vonage\Client($basic);

                // $response = $client->sms()->send(
                //     new \Vonage\SMS\Message\SMS($reminder->number, 'CYBER ACE', $reminder->name . ', pay ' . $reminder->amount . '.')
                // );
                
                // $message = $response->current();
                
                $reminder->sent = 1;
                $reminder->save();
            }
        }
    }
    public function send(Request $request) {
      
    }
}
