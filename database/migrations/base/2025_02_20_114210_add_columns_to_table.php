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
            $table->boolean('free_trial')->after('program_name')->default(false);
        });

        Schema::table('temp_users', function (Blueprint $table) {
            $table->boolean('has_npwp')->after('inhouse')->default(false); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_programs', function (Blueprint $table) {
            $table->dropColumn('free_trial');
        });

        Schema::table('temp_users', function (Blueprint $table) {
            $table->dropColumn('has_npwp');
        });
    }
};
