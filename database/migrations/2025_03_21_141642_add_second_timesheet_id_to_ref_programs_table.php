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
        Schema::table('ref_programs', function (Blueprint $table) {
            $table->unsignedBigInteger('scnd_timesheet_id')->after('timesheet_id')->nullable();
            $table->foreign('scnd_timesheet_id')->references('id')->on('timesheets')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_programs', function (Blueprint $table) {
            $table->dropForeign('scnd_timesheet_id');
            $table->dropColumn('scnd_timesheet_id');
        });
    }
};
