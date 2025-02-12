<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curriculum_names = [
            'IB Diploma Programe',
            'Cambridge A-level',
            'IB MYP',
            'Cambridge IGCSE',
            'Advanced Placement',
            'Academic Writing',
            'IELTS Prep',
            'TOEFL Prep',
            'Olympiad'
        ];
        for ($i = 0 ; $i < count($curriculum_names) ; $i++)
        {
            $seeds[] = [
                'name' => $curriculum_names[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Curriculum::insert($seeds);
    }
}
