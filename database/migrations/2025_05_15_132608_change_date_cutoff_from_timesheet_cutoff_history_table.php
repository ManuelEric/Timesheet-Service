<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('timesheet_cutoff_history', function (Blueprint $table) {
            $table->datetime('from')->change();
            $table->datetime('to')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timesheet_cutoff_history', function (Blueprint $table) {
            $table->date('from')->change();
            $table->date('to')->change();
        });
    }
};
