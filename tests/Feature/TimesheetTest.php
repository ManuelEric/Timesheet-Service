<?php

namespace Tests\Feature;

use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction;
use App\Models\User;
use App\Services\Timesheet\CreateTimesheetService;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\mock;
use function Pest\Laravel\postJson;

it('creates a timesheet successfully', function () {
    
    // Find an admin user 
    $user = User::where('email', 'admin@edu-all.com')->first();

    actingAs($user);

    // Mock the action
    mock(SelectOrRegisterMentorTutorAction::class)
        ->shouldReceive('handle')
        ->once()
        ->with('tutor@example.com')
        ->andReturn(999);

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
        'ref_id' => [1],
        'mentortutor_email' => 'tutor@example.com',
        'inhouse_id' => 1,
        'package_id' => 1,
        'duration' => 60,
        'pic_id' => 1,
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
