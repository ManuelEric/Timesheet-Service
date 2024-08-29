<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\PaidActivitiesAction;
use App\Actions\Payment\UnpaidActivitiesAction;
use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentDateConverter;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function index(
        Request $request,
        UnpaidActivitiesAction $unpaidActivitiesAction,
        PaidActivitiesAction $paidActivitiesAction,
        ): JsonResponse
    {
        $paymentStatus = $request->segment(4) == "paid" ? "completed" : "not yet"; # either unpaid / paid

        /* incoming request */
        $search = $request->only(['program_name', 'package_id', 'mentor_id', 'keyword', 'cutoff_start', 'cutoff_end']);
        
        switch ( $paymentStatus ) {
            # completed meaning paid
            case "completed":
                $mappedActivities = $paidActivitiesAction->execute($search);

                $totalFee = $mappedActivities->sum('subtotal'); 
                $additionalInfo = collect(['total_fee' => $totalFee]);
                break;

            # not yet meaning unpaid
            case "not yet":
                $mappedActivities = $unpaidActivitiesAction->execute($search);
                break;
        }
        
        $paginateActivities = $mappedActivities->paginate(10);
    
        if ($paymentStatus == "completed")
            $paginateActivities = $additionalInfo->merge($paginateActivities);
    
        return response()->json($paginateActivities);
    }
}
