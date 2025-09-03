<?php

namespace App\Console\Commands;

use App\Models\Curriculum;
use App\Models\Ref_Program;
use App\Models\TempUserRoles;
use App\Models\Timesheet;
use Illuminate\Console\Command;

class ResetSubject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-subject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset All of inactive subject that has been attached to timesheet and replace it with the active one.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updated_subject = $updated_timesheet = [];
        $timesheets = Timesheet::all();
        foreach ($timesheets as $timesheet) 
        {
            array_push($updated_timesheet, $timesheet->id);
            /* only update data timesheet for tutor */
            if ($timesheet->subject->role != 'Tutor')
                continue;

            /* program requirement */
            $program_curriculum = $timesheet->ref_program[0]->curriculum;
            $this->replaceSubjectID($program_curriculum, $timesheet, $updated_subject);
            
            if ($program_curriculum = $timesheet->second_ref_program[0])
            {
                $this->replaceSubjectID($program_curriculum->curriculum, $timesheet, $updated_subject);
            }
        }

        $this->info("Total of ".count($updated_timesheet)." timesheet has been processed.");
        $this->info("List of timesheet id that has been processed: ".implode(", ", $updated_timesheet));
        $this->info("Total of ".count($updated_subject)." subject has been replaced.");
        $this->info("List of subject id that has been replaced: ".implode(", ", $updated_subject));
    }

    private function replaceSubjectID ($program_curriculum, $timesheet, $updated_subject)
    {
        $curriculum_id = Curriculum::where('alias', $program_curriculum)->first()?->id;

        /* check if subject is inactive */
        $subject_id = $timesheet->subject_id;
        $subject = TempUserRoles::find($subject_id);
        if ($subject->is_active == 0)
        {
            $active_subject = TempUserRoles::where('temp_user_id', $subject->temp_user_id)
                                ->where('tutor_subject', $subject->tutor_subject)
                                ->when($curriculum_id, function ($query) use ($curriculum_id) {
                                    $query->where('curriculum_id', $curriculum_id);
                                })
                                ->active()
                                ->first();

            if ( !$active_subject )
                return;

            /* save subject_id before replaced */
            array_push($updated_subject, $timesheet->subject_id);

            /* replace current subject_id on timesheet to the active one */
            $timesheet->subject_id = $active_subject->id;
            $timesheet->save();  
        }
    }
}
