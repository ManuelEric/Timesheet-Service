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
        Schema::create('new_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('mentor_id')->constrained(
                table: 'temp_users', indexName: 'new_requests_mentor_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('clientprog_id')->nullable();
            $table->char('invoice_id', 50);
            $table->string('student_uuid');
            $table->string('student_name')->nullable();
            $table->string('student_school')->nullable();
            $table->string('student_grade')->nullable();
            $table->string('program_name');
            $table->foreignId('engagement_type_id')->constrained(
                table: 'engagement_types', indexName: 'new_requests_engagement_type_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_requests');
    }
};
