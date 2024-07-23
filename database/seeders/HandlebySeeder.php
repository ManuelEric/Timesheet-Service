<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HandlebySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pivot\HandleBy::withoutEvents(function () {
            \App\Models\Pivot\HandleBy::factory(5)->create();
        });
    }
}
