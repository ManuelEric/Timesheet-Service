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
            $table->unsignedBigInteger('engagement_type_id')->nullable()->after('timesheet_id');
            $table->foreign('engagement_type_id')->references('id')->on('engagement_types')->onUpdate('cascade')->onDelete('cascade');
            $table->text('notes')->nullable()->after('engagement_type_id')->comment('note from mentor');
            $table->text('cancellation_reason')->nullable()->after('notes')->comment('note when request has cancelled');
            $table->timestamp('cancelled_at')->after('updated_at')->nullable();
            $table->foreignUlid('requested_by')->after('cancellation_reason')->nullable()->constrained(
                table: 'temp_users', indexName: 'ref_programs_requested_by'
            )->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('temp_users', function (Blueprint $table) {
            $table->boolean('has_npwp')->after('inhouse')->default(false);
        });

        Schema::table('timesheet_activities', function (Blueprint $table) {
            $table->double('tax')->after('end_date');
        });

        Schema::table('temp_user_roles', function (Blueprint $table) {
            $table->double('tax')->after('fee_group');
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

        Schema::table('timesheet_activities', function (Blueprint $table) {
            $table->dropColumn('tax');
        });

        Schema::table('temp_user_roles', function (Blueprint $table) {
            $table->dropColumn('tax');
        });


    }
};
