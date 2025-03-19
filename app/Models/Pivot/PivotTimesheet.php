<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PivotTimesheet extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'ref_id',
        'timesheet_id'
    ];
}
