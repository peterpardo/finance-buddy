<?php

namespace Database\Seeders;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Finance::where('user_id', 1)->where('type', 'expense')->delete();
        $user = User::find(1);
        $user->finance()->create([
            'type' => 'expense',
            'category' => 'Electric Bills',
            'amount' => 100,
            'description' => 'Description 1'
        ]);

        $user->finance()->create([
            'type' => 'expense',
            'category' => 'Luho Sa Buhay',
            'amount' => 60,
            'description' => 'Description 2'
        ]);

        $user->finance()->create([
            'type' => 'expense',
            'category' => 'Tuition',
            'amount' => 70,
            'description' => 'Description 3'
        ]);

        $user->finance()->create([
            'type' => 'expense',
            'category' => 'Foods',
            'amount' => 30,
            'description' => 'Description 4'
        ]);
    }
}
