<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "category" => $this->category,
            "clientprog_id" => $this->clientprog_id,
            "schprog_id" => $this->schprog_id,
            "invoice_id" => $this->invoice_id,
            "student_uuid" => $this->student_uuid,
            "student_name" => $this->student_name,
            "student_school" => $this->student_school,
            "student_grade" => $this->student_grade,
            "program_name" => $this->program_name,
            "free_trial" => $this->free_trial,
            "require" => $this->require,
            "timesheet_id" => $this->timesheet_id,
            "scnd_timesheet_id" => $this->scnd_timesheet_id,
            "engagement_type_id" => $this->engagement_type_id,
            "notes" => $this->notes,
            "cancellation_reason" => $this->cancellation_reason,
            "requested_by" => $this->requested_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "cancelled_at" => $this->cancelled_at,
            "tutor_name" => $this->getTutorsName(),
        ];
    }

    private function getTutorsName(): string
    {
        $first_tutor = $second_tutor = $tutors_name = "";
        if ( $this->timesheet != null ) {
            $first_tutor = $this->timesheet->subject->temp_user->full_name;
            $tutors_name .= $first_tutor;
        }

        if ( $this->second_timesheet != null ) {
            $second_tutor = $this->second_timesheet->subject->temp_user->full_name;
            $tutors_name .= ($first_tutor ? ", " : "") . $second_tutor;
        }
        return $tutors_name;    
    }
}
