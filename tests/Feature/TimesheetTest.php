<?php

namespace Tests\Feature;

use App\Actions\Activity\CreateActivityAction;
use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction;
use App\Models\User;
use App\Services\Timesheet\CreateTimesheetService;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Models\Timesheet;
use Mockery;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\mock;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'admin@edu-all.com',
    ]);
});

it('creates a timesheet successfully', function () {
    // Find an admin user 
    // $user = User::where('email', 'admin@edu-all.com')->first();

    actingAs($this->user);

    // Mock the action
    mock(SelectOrRegisterMentorTutorAction::class)
        ->shouldReceive('handle')
        ->once()
        ->with('paul.edison@edu-all.com')
        ->andReturn('01J9AN0WXEZZWJAPQ639ENC7MN');

    // Mock the timesheet creation service
    mock(CreateTimesheetService::class)
        ->shouldReceive('storeTimesheet')
        ->once()
        ->andReturn((object)[
            'id' => 123,
            'list_of_student_name' => 'Test Student'
        ]);

    // Define valid payload
    $payload = [
        'ref_id' => [124],
        'mentortutor_email' => 'paul.edison@edu-all.com',
        'inhouse_id' => 'd481f68f-a5d7-495f-9792-336388249cc9',
        'package_id' => 1,
        'duration' => 60,
        'pic_id' => ['03J7DBWSKH3W8FD82J8NEPTW2P'],
        'notes' => 'Test note',
        'subject_id' => 1,
        'subject_name' => 'Math',
        'individual_fee' => 100,
        'tax' => 10,
        'curriculum_id' => 2,
    ];

    // Call API
    postJson('/api/v1/timesheet/create', $payload)
        ->assertOk()
        ->assertJson([
            'message' => 'Timesheet has been created successfully.',
            'data' => [
                'timesheet_id' => 123,
                'student_name' => 'Test Student',
            ],
        ]);
});

it ('creates activities successfully', function () {

    $this->actingAs($this->user);

    // Mock timesheet object
    $timesheet = Mockery::mock(Timesheet::class);

    // Mock IdentifyTimesheetIdAction
    mock(IdentifyTimesheetIdAction::class)
        ->shouldReceive('execute')
        ->once()
        ->with(123)
        ->andReturn($timesheet);

    // Mock CreateActivityAction
    mock(CreateActivityAction::class)
        ->shouldReceive('execute')
        ->once()
        ->with($timesheet, Mockery::type('array'))
        ->andReturnTrue();

    $payload = [
        'description' => 'Test activity',
        'start_date' => '2024-06-01 10:00:00',
        'end_date' => '2024-06-01 11:00:00',
        'meeting_link' => 'https://zoom.us/test',
        'status' => 1,
    ];

    $response = $this->postJson('/api/v1/timesheet/123/activity', $payload);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Activity has created successfully.'
        ]);
});
