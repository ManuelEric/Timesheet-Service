<?php

namespace App\Console\Commands\Synchronization;

use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Models\Ref_Program;
use App\Services\ResponseService;
use App\Services\Token\TokenService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SuccessProgramCommand extends Command
{
    use ConcatenateName;
    use HttpCall;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:success-program';

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
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/list');
        if (! $response) {
            $this->error('There are no data.');
            return COMMAND::FAILURE;
        }

        /* definition */
        $progress = $this->output->createProgressBar(count($response));
        $progress->start();

        $refs = array();
        foreach ($response as $crm_success_program) #both b2c & b2b 
        {
            /* define for both b2c and b2b variables */
            $category = $crm_success_program['category'];
            $clientprog_id = $schprog_id = $student_uuid = $student_name = NULL;
            $invoice_id = $crm_success_program['invoice_id'];
            $student_school = $crm_success_program['client']['school_name'];
            $program_name = $crm_success_program['program_name'];
            $require = $crm_success_program['require'];

            if ($category == 'b2c') {
                /* define b2c variables */
                $clientprog_id = $crm_success_program['clientprog_id'];
                $student_uuid = $crm_success_program['client']['uuid'];
                $student_name = $this->concat($crm_success_program['client']['first_name'], $crm_success_program['client']['last_name']);
            }
            
            if ($category == 'b2b') {
                /* define b2b variables */
                $schprog_id = $crm_success_program['schprog_id'];
            }


            /* check existence of success program on timesheet app */
            if ( Ref_Program::whereWetherB2C_B2B($category, $clientprog_id, $schprog_id)->exists() )
                continue; # don't put existing clientprog_id / schprog_id into refs[]

            $refs[] = [
                'category' => $category,
                'clientprog_id' => $clientprog_id,
                'schprog_id' => $schprog_id,
                'invoice_id' => $invoice_id,
                'student_uuid' => $student_uuid,
                'student_name' => $student_name,
                'student_school' => $student_school,
                'program_name' => $program_name,
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

        } catch (Exception $e) {

            DB::rollBack();
            $this->responseService->storeErrorLog(
                'Failed to sync success-program from CRMs.', 
                $e->getMessage(), 
                [
                    'file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]
            );
            $this->error('Synchronize failed. Error: ' . $e->getMessage());
            return COMMAND::FAILURE;

        }

        $message = count($refs) . ' success-program has been stored.';
        $this->responseService->storeInfoLog($message, $refs);

        $this->newLine();
        $this->info($message);
        return COMMAND::SUCCESS;
    }
}
