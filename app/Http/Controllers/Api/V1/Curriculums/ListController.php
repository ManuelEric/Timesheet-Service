<?php

namespace App\Http\Controllers\Api\V1\Curriculums;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * The component functions
     */
    public function component()
    {
        return response()->json(Curriculum::get());
    }
}
