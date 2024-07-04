<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Guidance',
                'package' => 'Starter',
                'detail' => 360,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Guidance',
                'package' => 'Regular',
                'detail' => 600,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Guidance',
                'package' => 'Premium',
                'detail' => 960,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Passion Project Mentoring',
                'package' => 'Hourly',
                'detail' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Mentors',
                'package' => 'Mentee',
                'detail' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Project Mentoring',
                'package' => 'Already always set',
                'detail' => 600,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Competition Mentoring',
                'package' => NULL,
                'detail' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Interview Mentoring',
                'package' => 'Hourly',
                'detail' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'ALL',
                'package' => 'Trial',
                'detail' => 60,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'ALL',
                'package' => 'Hourly',
                'detail' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Academic Tutoring',
                'package' => 'Basic',
                'detail' => 300,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Academic Tutoring',
                'package' => 'Pro',
                'detail' => 600,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Academic Tutoring',
                'package' => 'Elite',
                'detail' => 900,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'SAT',
                'package' => 'Private 26H',
                'detail' => 1200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'SAT',
                'package' => 'Private 36H',
                'detail' => 1800,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'SAT',
                'package' => 'Semi-Private 40H',
                'detail' => 2040,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'IELTS/TOEFL/English Acad Writing',
                'package' => 'Intensive',
                'detail' => 720,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Coding',
                'package' => 'Intensive',
                'detail' => 1080,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        \App\Models\Package::insert($seeds);
    }
}
