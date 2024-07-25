<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(AdminSeeder::class);
        // $this->call(PackageSeeder::class);

        /* setup data test */
        // $this->call(TempUserSeeder::class);
        // $this->call(TempUserRolesSeeder::class);
        // $this->call(TimesheetSeeder::class);
        // $this->call(ActivitySeeder::class);

        /* manually update the timesheet_id inside ref_programs */
        $refPrograms = \App\Models\Ref_Program::whereNull('timesheet_id')->get();
        foreach ($refPrograms as $refProgram) {
            $refProgram->timesheet_id = \App\Models\Timesheet::inRandomOrder()->first()->id;
            $refProgram->save();
        }
    }
}
