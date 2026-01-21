<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'あか',
                'email_verified_at' => now(),
                'password' => Hash::make('pass1234'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => '取引相手',
                'email_verified_at' => now(),
                'password' => Hash::make('pass5678'),
            ]
        );
    }
}