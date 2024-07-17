<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Cutoff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CutoffController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $validated = $request->only(['start_date', 'end_date']);
        $validatedStartDate = $validated['start_date'];
        $validatedEndDate = $validated['end_date'];

        /* select all activities between start_date and end_date */
        $goingToBePaidActivities = Activity::query()->
            unpaid()->
            where($validatedStartDate, '<=', 'start_date')->
            where($validatedEndDate, '>=', 'end_date')->
            pluck('id')->
            toArray();

        /* store cut-off as reference */
        $cutoff = new Cutoff;
        $cutoff->month = Carbon::parse($validatedEndDate)->format('M');
        $cutoff->from = $validatedStartDate;
        $cutoff->to = $validatedEndDate;
        $cutoff->save();
    }
}
