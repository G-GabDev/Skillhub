<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'user_id' => 1, // Alice
            'title' => 'Website Redesign',
            'description' => 'Need a freelancer to redesign my business website using modern UI principles.',
            'budget' => 1500.00,
            'deadline' => '2025-12-15',
        ]);

        Project::create([
            'user_id' => 2, // Bob
            'title' => 'Mobile App Development',
            'description' => 'Looking for an Android/iOS developer to build a simple task management app.',
            'budget' => 2500.00,
            'deadline' => '2026-01-10',
        ]);
    }
}
