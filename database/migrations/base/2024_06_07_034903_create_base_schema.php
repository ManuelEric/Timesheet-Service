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
        Schema::create('temp_users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('uuid')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->text('password')->nullable();
            $table->boolean('inhouse')->default(false);
            $table->datetime('last_activity')->nullable();
            $table->timestamps();
        });

        Schema::create('temp_user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('temp_user_id')->constrained(
                table: 'temp_users', indexName: 'temp_user_roles_temp_user_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->string('role');
            $table->string('tutor_subject')->nullable();
            $table->bigInteger('fee_hours')->default(0);
            $table->bigInteger('fee_session')->default(0);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('full_name');
            $table->string('email');
            $table->text('password');
            $table->enum('role', ['super_admin', 'admin', 'finance']);
            $table->datetime('last_activity')->nullable();
            $table->timestamps();
        });

        Schema::create('timesheet_packages', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('type_of');
            $table->string('package')->nullable();
            $table->integer('detail')->nullable();
            $table->timestamps();
        });

        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('inhouse_id')->references('uuid')->on('temp_users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('package_id')->constrained(
                table: 'timesheet_packages', indexName: 'timesheets_package_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->integer('duration');
            $table->text('notes')->nullable();
            $table->foreignId('subject_id')->constrained(
                table: 'temp_user_roles', indexName: 'timesheets_subject_id',
            )->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('timesheet_pics', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('user_id')->constrained(
                table: 'users', indexName: 'timesheet_pics_user_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('timesheet_id')->constrained(
                table: 'timesheets', indexName: 'timesheet_pics_timesheet_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('timesheet_handle_by', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('temp_user_id')->constrained(
                table: 'temp_users', indexName: 'timesheet_handle_by_temp_user_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('timesheet_id')->constrained(
                table: 'timesheets', indexName: 'timesheet_handle_by_timesheet_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('timesheet_cutoff_history', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('month', 15)->nullable();
            $table->date('from');
            $table->date('to');
            $table->timestamps();
        });

        Schema::create('timesheet_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_id')->constrained(
                table: 'timesheets', indexName: 'timesheet_activities_timesheet_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->string('activity');
            $table->text('description');
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->decimal('fee_hours');
            $table->decimal('additional_fee');
            $table->float('time_spent')->comment('in hours');
            $table->text('meeting_link');
            $table->integer('status');
            $table->enum('cutoff_status', ['paid', 'unpaid'])->default('unpaid');
            $table->foreignUlid('cutoff_ref_id')->nullable()->constrained(
                table: 'timesheet_cutoff_history', indexName: 'timesheet_activities_cutoff_ref_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('ref_programs', function (Blueprint $table) {
            $table->id();
            $table->enum('category',['b2c', 'b2b']);
            $table->bigInteger('clientprog_id')->nullable();
            $table->bigInteger('schprog_id')->nullable();
            $table->char('invoice_id', 50);
            $table->string('student_uuid');
            $table->string('student_name')->nullable();
            $table->string('student_school');
            $table->string('program_name');
            $table->enum('require', ['Mentor', 'Tutor']);
            $table->foreignId('timesheet_id')->nullable()->constrained(
                table: 'timesheets', indexName: 'ref_programs_timesheet_id'
            )->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('logging', function (Blueprint $table) {
            $table->string('id')->nullable()->comment('user identity');
            $table->text('user')->nullable();
            $table->text('activity');
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_users');
        Schema::dropIfExists('users');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('timesheets');
        Schema::dropIfExists('timesheet_pics');
        Schema::dropIfExists('timesheet_handle_by');
        Schema::dropIfExists('timesheet_cutoff_history');
        Schema::dropIfExists('timesheet_activities');
        Schema::dropIfExists('ref_programs');
        Schema::dropIfExists('logging');
    }
};
