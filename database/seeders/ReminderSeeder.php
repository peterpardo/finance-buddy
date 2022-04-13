<?php

namespace Database\Seeders;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reminder::where('user_id', 1)->delete();
        $user = User::find(1);
        $user->reminders()->create([
            'name' => 'Bill',
            'number' => '639453175950',
            'amount' => 100,
            'sent' => 1,
            'date' => '2022-03-10'
        ]);
        $user->reminders()->create([
            'name' => 'Smith',
            'number' => '639453175950',
            'amount' => 50,
            'sent' => 1,
            'date' => '2022-03-9'
        ]);
        $user->reminders()->create([
            'name' => 'Stan',
            'number' => '639453175950',
            'amount' => 30,
            'sent' => 0,
            'date' => '2022-03-11'
        ]);
        $user->reminders()->create([
            'name' => 'Jane',
            'number' => '639453175950',
            'amount' => 110,
            'sent' => 0,
            'date' => '2022-03-12'
        ]);
    }
}
