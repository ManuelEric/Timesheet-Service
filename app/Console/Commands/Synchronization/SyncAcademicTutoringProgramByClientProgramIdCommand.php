<?php

namespace App\Console\Commands\Synchronization;

use App\Services\Program\RefProgramServices;
use App\Services\ResponseService;
use App\Services\Token\TokenService;
use Exception;
use Illuminate\Console\Command;

class SyncAcademicTutoringProgramByClientProgramIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manual:sync-academic-program {clientprogram_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually help synchronize CRM application academic tutoring program based on inputted clientprogram id';

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
        $clientprogram_id = $this->argument('clientprogram_id');
        /* call API to get all of the success and paid programs */
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/academic/identifier/'. $clientprogram_id);
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
