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
        Schema::table('temp_user_roles', function (Blueprint $table) {
            $table->date('end_date')->nullable()->comment('active period')->after('tutor_subject');
            $table->date('start_date')->nullable()->comment('active period')->after('tutor_subject');
            $table->foreignId('engagement_type_id')->after('tutor_subject')->nullable()->constrained(
                table: 'engagement_types', indexName: 'temp_user_roles_engagement_type_id_foreign'
            )->comment('will related to package_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('package_id')->after('tutor_subject')->nullable()->constrained(
                table: 'timesheet_packages', indexName: 'temp_user_roles_package_id_foreign'
            )->onUpdate('cascade')->onDelete('cascade');
            // $table->string('ext_mentor_package')->nullable()->comment('will be filled when role is External Mentor')->after('tutor_subject');
            $table->string('ext_mentor_stream')->nullable()->comment('will be filled when role is External Mentor')->after('tutor_subject');
            $table->boolean('is_active')->default(true)->after('tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_user_roles', callback: function (Blueprint $table) {
            $table->dropColumn('end_date');
            $table->dropColumn('start_date');
            $table->dropForeign('temp_user_roles_engagement_type_id_foreign');
            $table->dropColumn('engagement_type_id');
            $table->dropForeign('temp_user_roles_package_id_foreign');
            $table->dropColumn('package_id');
            $table->dropColumn('ext_mentor_stream');
            $table->dropColumn('is_active');
        });
    }
};
