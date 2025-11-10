<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        Proposal::create([
            'project_id' => 1, // Website Redesign
            'user_id' => 3, // Charlie
            'cover_letter' => 'I have 3 years of experience in web design. I can complete your redesign efficiently.',
            'bid_amount' => 1400.00,
            'status' => 'pending',
        ]);

        Proposal::create([
            'project_id' => 2, // Mobile App Development
            'user_id' => 4, // Diana
            'cover_letter' => 'I specialize in cross-platform development using React Native. Excited to collaborate!',
            'bid_amount' => 2300.00,
            'status' => 'pending',
        ]);
    }
}
