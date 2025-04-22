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
            $table->unsignedBigInteger('mentoring_log_id')->nullable()->comment('will be filled with primary of mentoring-log from mentoring table')->after('requested_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_programs', function (Blueprint $table) {
            $table->dropColumn('mentoring_log_id');
        });
    }
};
