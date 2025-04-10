<?php

namespace App\Console\Commands\Synchronization;

use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Models\Ref_Program;
use App\Services\ResponseService;
use App\Services\Token\TokenService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FreeTrialProgramCommand extends Command
{
    use HttpCall;
    use ConcatenateName;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:free-trial-program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize CRM application success program.';

    protected $responseService;
    protected $tokenService;

    public function __construct(ResponseService $responseService, TokenService $tokenService)
    {
        parent::__construct();
        $this->responseService = $responseService;
        $this->tokenService = $tokenService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* call API to get all of the success and paid programs */
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/list/free-trial');
        if (! $response) {
            $this->error('There are no data.');
            return COMMAND::FAILURE;
        }

        /* definition */
        $progress = $this->output->createProgressBar(count($response));
        $progress->start();

        $refs = array();
        $no = 1;
        foreach ($response as $crm_free_trial_program) #both b2c & b2b 
        {
            /* define for both b2c and b2b variables */
            $category = $crm_free_trial_program['category'];
            $clientprog_id = $schprog_id = $student_uuid = $student_name = $student_grade = NULL;
            $student_school = $crm_free_trial_program['client']['school_name'];
            $program_name = $crm_free_trial_program['program_name'];
            $require = $crm_free_trial_program['require'];
            $clientprog_id = $crm_free_trial_program['clientprog_id'];
            $student_uuid = $crm_free_trial_program['client']['uuid'];
            $student_name = $this->concat($crm_free_trial_program['client']['first_name'], $crm_free_trial_program['client']['last_name']);
            $student_grade = $crm_free_trial_program['client']['grade'];
            

            /* check existence of success program on timesheet app */
            if ( Ref_Program::whereWetherB2C_B2B($category, $clientprog_id, $schprog_id)->trial()->exists() )
            {
                Ref_Program::where('clientprog_id', $clientprog_id)->update(['student_grade' => $student_grade]); # just update the student grade
                continue; # don't put existing clientprog_id / schprog_id into refs[]
            }

            $refs[] = [
                'category' => $category,
                'clientprog_id' => $clientprog_id,
                'schprog_id' => $schprog_id,
                'student_uuid' => $student_uuid,
                'student_name' => $student_name,
                'student_school' => $student_school,
                'student_grade' => $student_grade,
                'program_name' => $program_name,
                'free_trial' => 1,
                'require' => $require,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $progress->advance();
        }

        DB::beginTransaction();
        try {

            Ref_Program::insert($refs);
            DB::commit();
            $progress->finish();

        } catch (\Exception $e) {

            DB::rollBack();
            $this->responseService->storeErrorLog(
                'Failed to sync free-trial-program from CRMs.', 
                $e->getMessage(), 
                [
                    'file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]
            );
            $this->error('Synchronize failed. Error: ' . $e->getMessage());
            return COMMAND::FAILURE;

        }

        $message = count($refs) . ' free-trial program has been stored.';
        $this->responseService->storeInfoLog($message, $refs);

        $this->newLine();
        $this->info($message);
        return COMMAND::SUCCESS;
    }
}
