<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Services\Activity\ActivityDataService;
use App\Services\Timesheet\TimesheetDataService;

class PayrollExportMultipleSheets implements WithMultipleSheets
{
    protected $export_sheets;

    public function __construct($export_sheets)
    {
        $this->export_sheets = $export_sheets;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        return $this->export_sheets;
    }
}
