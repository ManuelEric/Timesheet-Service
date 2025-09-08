<?php

namespace App\Console\Commands;

use App\Models\Curriculum;
use App\Models\Ref_Program;
use App\Models\TempUserRoles;
use App\Models\Timesheet;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {

            foreach ($timesheets as $timesheet) 
            {
                if ($timesheet->id != 211)
                    continue;
                
                array_push($updated_timesheet, $timesheet->id);
                $this->info('Timesheet ID: '.$timesheet->id. ' need role: '.$timesheet->subject->role);
                /* only update data timesheet for tutor */
                if ($timesheet->subject->role != 'Tutor')
                    continue;
    
                /* program requirement */
                $programs = [
                    $timesheet->ref_program[0] ?? null,
                    $timesheet->second_ref_program[0] ?? null,
                ];
    
                foreach ($programs as $program) {
                    if ( $program ) {
                    //! condition below is commented because when there is a program whose curriculum is null, it will skip the check and not replace the subject
                    //! while we need to check whether curriculum is null or not
                    // if ($program && isset($program->curriculum)) {
                        $this->replaceSubjectID($program->curriculum, $timesheet, $updated_subject);
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("Error: ".$e->getMessage());
            return true;
        }

        $this->info("Total of ".count($updated_timesheet)." timesheet has been processed.");
        $this->info("List of timesheet id that has been processed: ".implode(", ", $updated_timesheet));
        $this->info("Total of ".count($updated_subject)." subject has been replaced.");
        $this->info("List of subject id that has been replaced: ".implode(", ", $updated_subject));
    }

    private function replaceSubjectID ($program_curriculum, $timesheet, array $updated_subject = [])
    {
        $curriculum_id = Curriculum::where('alias', $program_curriculum)->first()?->id;

        /* check if subject is inactive */
        $subject_id = $timesheet->subject_id;
        $this->info($subject_id);
        $subject = TempUserRoles::find($subject_id);
        if ($subject->is_active == 1)
            return true;
        
        $active_subject = TempUserRoles::where('temp_user_id', $subject->temp_user_id)
                            ->where('tutor_subject', $subject->tutor_subject)
                            ->when($curriculum_id, function ($query) use ($curriculum_id) {
                                $query->where('curriculum_id', $curriculum_id);
                            })
                            ->active()
                            ->first();

        if ( !$active_subject )
        {
            $this->error("No active subject found for subject ID: $subject_id");
            return true;
        }

        
        /* save subject_id before replaced */
        if ($subject_id != null)
            array_push($updated_subject, $subject_id);

        /* replace current subject_id on timesheet to the active one */
        $timesheet->subject_id = $active_subject->id;
        $timesheet->save();  
    }
}
