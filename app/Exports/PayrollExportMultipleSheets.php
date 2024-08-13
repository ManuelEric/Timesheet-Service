<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PayrollExportMultipleSheets implements WithMultipleSheets
{
    public function __construct($timesheets)
    {
        
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        /* TODOS */
        /* need to looping timesheets */
        $exports = [];

        return $exports;
    }
}
