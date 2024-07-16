<?php

namespace App\Services\Token;

use Illuminate\Support\Facades\DB;

class TokenService 
{
    /**
     * get active token for external timesheet App from CRM.
     */
    public function get()
    {
        return DB::connection('mysql_crmv2')->table('token_lib')->where('header_name', 'Header-ET')->first()->value;
    }
}
