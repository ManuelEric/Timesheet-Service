<?php

namespace App\Http\Traits;

trait ManipulateProgramName
{
    public function fetchSubjectOnly(String $program_name): string
    {
        $explode = explode(':', $program_name);
        return end($explode);
    }

    public function fetchMainProgram(String $program_name): string
    {
        $explode = explode(':', $program_name);
        return $explode[0];
    }
}
