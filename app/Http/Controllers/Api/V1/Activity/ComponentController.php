<?php

namespace App\Http\Controllers\Api\V1\Activity;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\SummaryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ComponentController extends Controller
{    
    public function monthlyActivities(
        string $requestedMonthYear,
        SummaryService $summaryService,
        ): JsonResponse
    {
        [$year, $month] = $summaryService->fetchMonthAndYear($requestedMonthYear);
        $activities = Activity::onSession()->whereMonth('start_date', $month)->whereYear('start_date', $year)->get();
        $mappedActivities = $activities->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->description,
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
