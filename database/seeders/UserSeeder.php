<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['username' => 'aldmic'],
            [
                'email' => 'aldmic@example.com',
                'password' => Hash::make('123abc123'),
            ]
        );
    }
}
