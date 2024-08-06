<?php

namespace App\Console\Commands\Synchronization;

use App\Actions\Authentication\CheckEmailMentorTutorAction;
use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Services\Token\TokenService;
use App\Services\User\CreateTempUserService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Exceptions\HttpResponseException;

class TutorMentorCommand extends Command
{
    use HttpCall;
    use ConcatenateName;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:tutor-mentor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize CRM application Tutor & Mentor';

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        parent::__construct();
        $this->tokenService = $tokenService;
    }

    /**
     * Execute the console command.
     */
    public function handle(
        CheckEmailMentorTutorAction $checkEmailMentorTutorAction,
        CreateTempUserService $createTempUserService,
        )
    {
        [$statusCode, $mentorTutors] = $this->make_call('get', env('CRM_DOMAIN') . 'user/mentor-tutors');
        $progress = $this->output->createProgressBar(count($mentorTutors));
        $progress->start();
        
        foreach ( $mentorTutors as $mentorTutor )
        {
            try {

                $name = $this->concat($mentorTutor['first_name'], $mentorTutor['last_name']);
                $email = $mentorTutor['email'];
                [$emailCheckingResult, $userRawInformation] = $checkEmailMentorTutorAction->execute($email);
                echo json_encode($userRawInformation);exit;
                $createTempUserService->execute($userRawInformation);
                $progress->advance();
    
            } catch (Exception $e) {

                $this->newLine();
                $this->error("Cannot stored user `{$name}` with email `{$email}`. Error: {$e->getMessage()}");
                continue;

            } catch (HttpResponseException $e) {

                $this->newLine();
                $this->error("Cannot stored user `{$name}` with email `{$email}`. Error: {$e->getMessage()}");
                continue;

            }

        }

        $progress->finish();
    }
}
