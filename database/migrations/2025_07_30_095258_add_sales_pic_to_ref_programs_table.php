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
            $table->string('sales_pic_name')->after('invoice_id')->nullable()->comment('Who was designated as the Person In Charge for the student');
            $table->string('sales_pic_phone')->after('sales_pic_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_programs', function (Blueprint $table) {
            $table->dropColumn('sales_pic_name');
            $table->dropColumn('sales_pic_phone');
        });
    }
};
