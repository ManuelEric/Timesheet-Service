<?php

namespace App\Services\Mentoring;

use App\Http\Traits\HttpCall;
use App\Models\Ref_Program;
use App\Services\Token\TokenService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MentoringServices
{
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    //! its not use anymore, because endpoint to store mentoring log has already update the quota 
    public function updateQuota(string $mentee_id, int $phase_detail_id, string $type)
    {
        $endpoint = env('CRM_DOMAIN') . "program-phase/{$mentee_id}/phase-detail/{$phase_detail_id}/use";
            
        [$status_code, $result] = $this->make_call('patch', $endpoint, [
            'use' => 1,
            'type' => $type
        ], ['crm-authorization' => env('CRM_AUTHORIZATION_KEY')]);
    }

    public function storeMentoringLog(
        int $ref_Program_id, 
        string $mentee_id, 
        int $phase_detail_id, 
        string $mentor_id, 
        string $activity_description,
        ?string $meeting_link = null,
        array $options = []
    )
    {
        $endpoint = env('MENTORING_DOMAIN') . "mentoring-log";

        // Log::info("Mentoring log creating for Ref Program ID: {$ref_Program_id}", [
        //     'student_id' => $mentee_id,
        //     'phase_detail_id' => $phase_detail_id,
        //     'start_date' => $options['start_date'],
        //     'end_date' => $options['end_date'],
        //     'mentor_id' => $mentor_id,
        //     'meeting_notes' => $activity_description,
        //     'meeting_link' => $meeting_link,
        // ]);
        [$status_code, $result] = $this->make_call('post', $endpoint, [
            'student_id' => $mentee_id,
            'phase_detail_id' => $phase_detail_id,
            'start_date' => $options['start_date'],
            'end_date' => $options['end_date'],
            'mentor_id' => $mentor_id,
            'meeting_notes' => $activity_description,
            'meeting_link' => $meeting_link,
        ], ['mentoring-authorization' => env('MENTORING_AUTHORIZATION_KEY')]);

        Log::info("Mentoring log created for Ref Program ID: {$ref_Program_id} with status code: {$status_code}");

        # update column mentoring_log_id using ref_program_id
        # in order to help determine which ref_program should be deleted if mentor cancel/delete the request
        Ref_Program::find($ref_Program_id)->update([
            'mentoring_log_id' => $result['data']['created_mentoring_log']['id'],
        ]);
    }

    public function deleteMentoringLog(int $ref_Program_id)
    {
        $ref_Program = Ref_Program::find($ref_Program_id);
        $endpoint = env('MENTORING_DOMAIN') . 'mentoring-log/' . $ref_Program->mentoring_log_id;

        [$status_code, $result] = $this->make_call('delete', $endpoint, [], ['mentoring-authorization' => env('MENTORING_AUTHORIZATION_KEY')]);

        # update column mentoring_log_id using ref_program_id
        # in order to help determine which ref_program should be deleted if mentor cancel/delete the request
        Ref_Program::find($ref_Program_id)->update([
            'mentoring_log_id' => null,
        ]);
    }
}
