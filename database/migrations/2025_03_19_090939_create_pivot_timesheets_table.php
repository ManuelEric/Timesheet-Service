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
        Schema::create('pivot_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_id')->constrained(
                table: 'ref_programs', indexName: 'pivot_timesheets_ref_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('timesheet_id')->constrained(
                table: 'timesheets', indexName: 'pivot_timesheets_timesheet_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_timesheets');
    }
};
