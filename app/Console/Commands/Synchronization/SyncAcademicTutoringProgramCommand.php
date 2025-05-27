<?php

namespace App\Console\Commands\Synchronization;

use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Models\Ref_Program;
use App\Services\Program\RefProgramServices;
use App\Services\ResponseService;
use App\Services\Token\TokenService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncAcademicTutoringProgramCommand extends Command
{
    use ConcatenateName;
    use HttpCall;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:academic-program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize CRM application academic tutoring program.';

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
    public function handle(RefProgramServices $refProgramServices)
    {
        /* call API to get all of the success and paid programs */
        // [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/academic/list');
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/tutoring/list');
        if (! $response) {
            $this->error('There are no data.');
            return COMMAND::FAILURE;
        }

        /* definition */
        $progress = $this->output->createProgressBar(count($response));
        $progress->start();
        
        try {
            $refs = $refProgramServices->createMany($response, true, ['progress' => $progress]);
        } catch (Exception $e) {
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

        $progress->finish();        

        $message = count($refs) . ' success-program has been stored.';
        $this->responseService->storeInfoLog($message, $refs);
        $this->newLine();
        $this->info($message);
        return COMMAND::SUCCESS;
    }
}
