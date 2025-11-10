<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Clients
        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@skillhub.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        User::create([
            'name' => 'Bob Smith',
            'email' => 'bob@skillhub.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // Freelancers
        User::create([
            'name' => 'Charlie Reyes',
            'email' => 'charlie@skillhub.com',
            'password' => Hash::make('password'),
            'role' => 'freelancer',
        ]);

        User::create([
            'name' => 'Diana Lopez',
            'email' => 'diana@skillhub.com',
            'password' => Hash::make('password'),
            'role' => 'freelancer',
        ]);
    }
}
