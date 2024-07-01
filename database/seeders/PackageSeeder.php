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
                'detail' => '6 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Guidance',
                'package' => 'Regular',
                'detail' => '10 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Guidance',
                'package' => 'Premium',
                'detail' => '16 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Passion Project Mentoring',
                'package' => 'Hourly',
                'detail' => 'Customize',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Essay Mentors',
                'package' => 'Mentee',
                'detail' => 'Customize',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'External Mentors',
                'type_of' => 'Project Mentoring',
                'package' => 'Already always set',
                'detail' => '10 hours',
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
                'detail' => 'Customize',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'ALL',
                'package' => 'Trial',
                'detail' => '1 hour',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'ALL',
                'package' => 'Hourly',
                'detail' => 'Customize',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Academic Tutoring',
                'package' => 'Basic',
                'detail' => '5 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Academic Tutoring',
                'package' => 'Pro',
                'detail' => '10 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Academic Tutoring',
                'package' => 'Elite',
                'detail' => '15 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'SAT',
                'package' => 'Private 26H',
                'detail' => '20 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'SAT',
                'package' => 'Private 36H',
                'detail' => '30 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'SAT',
                'package' => 'Semi-Private 40H',
                'detail' => '34 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'IELTS/TOEFL/English Acad Writing',
                'package' => 'Intensive',
                'detail' => '12 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Tutoring',
                'type_of' => 'Coding',
                'package' => 'Intensive',
                'detail' => '18 hours',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        \App\Models\Package::insert($seeds);
    }
}
