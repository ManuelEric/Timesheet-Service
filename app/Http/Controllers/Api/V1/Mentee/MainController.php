<?php

namespace App\Http\Controllers\Api\V1\Mentee;

use App\Actions\Mentees\FetchMenteesAction;
use App\Http\Controllers\Controller;
use App\Http\Traits\HttpCall;

class MainController extends Controller
{
    use HttpCall;

    public function index(
        FetchMenteesAction $fetchMenteesAction,
        )
    {
        $mentees = $fetchMenteesAction->execute();
        return response()->json($mentees);
        
    }
}
