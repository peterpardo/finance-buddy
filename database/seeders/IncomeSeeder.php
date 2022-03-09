<?php

namespace Database\Seeders;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Finance::where('user_id', 1)->where('type', 'income')->delete();
        $user = User::find(1);
        $user->finance()->create([
            'type' => 'income',
            'category' => 'Savings',
            'amount' => 100,
            'description' => 'Description 1'
        ]);

        $user->finance()->create([
            'type' => 'income',
            'category' => 'Salary',
            'amount' => 60,
            'description' => 'Description 2'
        ]);

        $user->finance()->create([
            'type' => 'income',
            'category' => 'Allowance',
            'amount' => 70,
            'description' => 'Description 3'
        ]);

        $user->finance()->create([
            'type' => 'income',
            'category' => 'Gift',
            'amount' => 30,
            'description' => 'Description 4'
        ]);
    }
}
