<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DefaultConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:default-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the initial data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:fresh --path=database/migrations/base');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('sync:tutor-mentor');
        Artisan::call('sync:success-program');

        # setting default inhouse mentor
        \App\Models\TempUser::whereIn('uuid', ['e37e529a-c8c6-45f5-9550-f438f892427d', '94384506-ac33-46d3-bbdd-1bb60fe3035e'])->update(['inhouse' => 1]);
    }
}
