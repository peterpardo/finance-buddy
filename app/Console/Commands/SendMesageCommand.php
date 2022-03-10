<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class SendMesageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reminders = Reminder::all();
        foreach($reminders as $reminder) {
            // Check date if it's due
            $date = Carbon::parse($reminder->date . "00:00:00", 'Asia/Manila');
            $isDue = Carbon::today('Asia/Manila')->lt($date);

            //  Send SMS if it's true
            if($isDue) {
                $basic  = new \Vonage\Client\Credentials\Basic("9b6de49c", "OGQVQ2BqfR1F4y32");
                $client = new \Vonage\Client($basic);

                $response = $client->sms()->send(
                    new \Vonage\SMS\Message\SMS($reminder->number, 'CYBER ACE', $reminder->name . ', pay ' . $reminder->amount . '.')
                );
                
                $message = $response->current();
                
                $reminder->sent = 1;
                $reminder->save();
            }
        }
    }
}
