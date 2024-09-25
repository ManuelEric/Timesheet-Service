<?php

namespace App\Exports;

use App\Models\Cutoff;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PayrollExport implements FromView, WithTitle
{
    protected $timesheet;
    protected $activities;

    public function __construct($timesheet, $activities)
    {
        $this->timesheet = $timesheet;
        $this->activities = $activities;
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

        # because there is possibilites, activities in 1 month could have different cutoff history
        # then we only take 1 cutoff history ID as reference for the whole month
        $cutoff_ref_id = $this->activities[0]['cutoff_ref_id'];
        $cutoff = Cutoff::find($cutoff_ref_id);

        $total_hour = $this->activities->sum('time_spent');

        $fee = $this->activities->map(function ($item) {
            return [
                'total_fee_per_activity' => ($item['time_spent'] / 60) * $item['fee_hours']
            ];
        });

        $total_fee = $fee->sum('total_fee_per_activity') + $this->activities->sum('additional_fee') + $this->activities->sum('bonus_fee');


        # merge all variables that going to show in view 
        $viewData = compact('isGroup', 'clients', 'activities', 'cutoff', 'total_hour', 'total_fee');

        return view('exports.payroll', $this->timesheet + $viewData);
    }
}
