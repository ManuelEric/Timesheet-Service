<?php

namespace App\Http\Controllers\Api\V1\Activity;

use App\Http\Controllers\Controller;
use App\Http\Traits\MonthCollection;
use App\Models\Activity;
use App\Services\SummaryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ComponentController extends Controller
{
    use MonthCollection;
    
    public function monthlyActivities(string $month): JsonResponse
    {
        if ( !in_array(strtolower($month), $this->month()) )
        {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid month provided.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        $index = array_search($month, $this->month()) + 1;

        $activities = Activity::onSession()->whereMonth('start_date', $index)->get();
        $mappedActivities = $activities->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->activity,
                'with' => $item->timesheet->handle_by->first()->full_name,
                'time' => [
                    'start' => Carbon::parse($item->start_date)->format('Y-m-d H:i'),
                    'end' => Carbon::parse($item->end_date)->format('Y-m-d H:i'),
                ],
                'isEditable' => false,
                'description' => $item->description
            ];
        });

        return response()->json($mappedActivities, JsonResponse::HTTP_OK);
    }

    public function summaryMonthlyActivities(
        string $month,
        SummaryService $summaryService,
        ): JsonResponse
    {
        $activity = $summaryService->summaryMonthlyActivities($month);
        return response()->json($activity, JsonResponse::HTTP_OK);
    }
}
