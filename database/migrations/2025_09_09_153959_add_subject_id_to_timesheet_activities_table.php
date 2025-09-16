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
        Schema::table('timesheet_activities', function (Blueprint $table) {
            $table->foreignId('subject_id')->nullable()->after('cutoff_status')->constrained(
                table: 'temp_user_roles', indexName: 'timesheet_activities_subject_id',
            )->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timesheet_activities', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\TempUserRoles::class);
            $table->dropColumn('subject_id');
        });
    }
};
