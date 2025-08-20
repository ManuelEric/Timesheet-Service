<?php

namespace App\Exports;

use App\Models\Cutoff;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SummaryExport implements FromView, WithTitle, WithColumnFormatting
{
    public Cutoff $cutoff;
    public $activities;
    public $editor_activities;

    public function __construct(Cutoff $cutoff, Collection $activities, Collection $editor_activities)
    {
        $this->cutoff = $cutoff;
        $this->activities = $activities;
        $this->editor_activities = $editor_activities;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        // ex: March 2025
        return ucfirst($this->cutoff->month);
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.fee-summary', [
            'activities' => $this->activities,
            'editor_activities' => $this->editor_activities
        ]);
    }
}
