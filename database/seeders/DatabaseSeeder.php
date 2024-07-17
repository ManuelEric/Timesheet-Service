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
        $this->call(AdminSeeder::class);
        $this->call(PackageSeeder::class);

        /* setup data test */
        $this->call(TempUserSeeder::class);
        $this->call(TempUserRolesSeeder::class);
        $this->call(TimesheetSeeder::class);
        $this->call(ActivitySeeder::class);
    }
}
