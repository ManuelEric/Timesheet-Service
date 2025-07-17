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
        Schema::table('temp_users', function (Blueprint $table) {
            $table->string('swift_code')->nullable()->after('has_npwp');
            $table->string('bank_name')->nullable()->after('has_npwp');
            $table->string('account_no')->nullable()->after('has_npwp');
            $table->string('account_name')->nullable()->after('has_npwp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_users', function (Blueprint $table) {
            $table->dropColumn(['swift_code', 'bank_name', 'account_no', 'account_name']);
        });
    }
};
