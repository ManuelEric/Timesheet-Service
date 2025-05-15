<?php

namespace App\Exports;

use App\Models\Cutoff;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PayrollExport implements FromView, WithTitle
{
    protected $timesheet;
    protected $activities;
    protected $cutoff;

    public function __construct($timesheet, $activities, $cutoff)
    {
        $this->timesheet = $timesheet;
        $this->activities = $activities;
        $this->cutoff = $cutoff;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return strtoupper($this->timesheet['packageDetails']['tutormentor_name']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        # because timesheet can be for single client and multiple clients and the way we show the data becomes different
        # so thats why we need parameter to tell user wether its group or non-group (i.e. sat or semi-private)
        $isGroup = count($this->timesheet['clientProfile']) > 1 ? true : false;

        # define the clients so that either client is single or multiple, we only use 1 variable
        $clients = $isGroup ? $this->timesheet['clientProfile'] : $this->timesheet['clientProfile'][0];

        # store the activities data into activities variable, so that viewData can allow to be inside compact()
        $activities = $this->activities;
        $cutoff = $this->cutoff;

        $total_hour = $this->activities->sum('time_spent');

        $fee = $this->activities->map(function ($item) {
            return [
                'total_fee_per_activity' => ($item['time_spent'] / 60) * $item['fee_hours'],
            ];
        });

        
        $total_fee_without_tax = $fee->sum('total_fee_per_activity') + $this->activities->sum('additional_fee') + $this->activities->sum('bonus_fee');

        # add tax here
        $percentage_of_tax = $this->timesheet['packageDetails']['tutormentor_tax'];
        $total_tax = ($percentage_of_tax / 100) * $total_fee_without_tax;

        $total_fee = $total_fee_without_tax - $total_tax;


        # merge all variables that going to show in view 
        $viewData = compact('isGroup', 'clients', 'activities', 'cutoff', 'total_hour', 'total_fee_without_tax', 'percentage_of_tax', 'total_tax', 'total_fee');

        return view('exports.payroll', $this->timesheet + $viewData);
    }
}
