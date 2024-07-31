<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
        DELIMITER //

        CREATE OR REPLACE FUNCTION sum_activity_time_based_on_timesheet ( req_timesheet_id INTEGER )
        RETURNS DOUBLE

            BEGIN
                DECLARE total_spent DOUBLE DEFAULT 0.00;

                SELECT SUM(time_spent) INTO total_spent
                    FROM timesheet_activities
                    WHERE timesheet_id = req_timesheet_id;

            RETURN total_spent;
        END; //

        DELIMITER ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
