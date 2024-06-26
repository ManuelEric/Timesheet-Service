<?php

namespace App\Console\Commands\Synchronization;

use App\Http\Traits\ConcatenateName;
use App\Models\Ref_ClientProgram;
use App\Services\ResponseService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class SuccessProgramCommand extends Command
{
    use ConcatenateName;
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

    /**
     * Execute the console command.
     */
    public function handle(ResponseService $responseService)
    {

        /* call API to get all of the success and paid programs */
        $request = Http::get( env('CRM_DOMAIN') . 'program/list');
        $response = $request->json();

        if (! $response) {
            $this->error('There are no data.');
        }

        /* definition */
        $progress = $this->output->createProgressBar(count($response));
        $progress->start();

        $refs = array();
        foreach ($response as $crm_program) 
        {
            $clientprog_id = $crm_program['clientprog_id'];
            $invoice_id = $crm_program['invoice_id'];
            $student_name = $this->concat($crm_program['client']['first_name'], $crm_program['client']['last_name']);
            $student_school = $crm_program['client']['school_name'];
            $program_name = $crm_program['program_name'];

            /* check existence of success program on timesheet app */
            if ( Ref_ClientProgram::where('clientprog_id', $clientprog_id)->exists() )
                continue; # don't put existing clientprog_id into refs[]

            $refs[] = [
                'clientprog_id' => $clientprog_id,
                'invoice_id' => $invoice_id,
                'student_name' => $student_name,
                'student_school' => $student_school,
                'program_name' => $program_name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $progress->advance();
        }

        DB::beginTransaction();
        try {

            Ref_ClientProgram::insert($refs);
            DB::commit();
            $progress->finish();

        } catch (Exception $e) {

            DB::rollBack();
            $responseService->storeErrorLog(
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
        $responseService->storeInfoLog($message, $refs);

        $this->newLine();
        $this->info($message);
        return COMMAND::SUCCESS;
    }
}
