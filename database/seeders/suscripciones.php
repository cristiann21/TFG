<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class suscripciones extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Suscripciones::create([
                'user_id' => $user->id,
                'plan' => 'bronce',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
            ]);
        }
    }

}
