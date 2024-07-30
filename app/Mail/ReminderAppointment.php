<?php

namespace App\Mail;

use App\Http\Traits\PackageType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderAppointment extends Mailable
{
    use Queueable, SerializesModels, PackageType;

    public $tries = 3; // Maximum number of retries
    public $title = 'Reminder Appointment';

    public $activityId;
    protected $programCategory;
    protected $dear;
    protected $clients;
    protected $activityStartDate;
    protected $activityStartTime;
    protected $activityMeetingLink;

    /**
     * Create a new message instance.
     */
    public function __construct($viewData)
    {
        $this->afterCommit();

        [$this->programCategory, $tutor_or_mentor] = $this->convert($viewData['additionalInfo']['package']['category']);

        /* going to be send to the view */
        $this->dear = $viewData['additionalInfo']['package']['tutormentor_name'];

        $this->clients = implode(", ", array_map(function ($entry) {
            return $entry['client_name'];
        }, $viewData['additionalInfo']['clients']) );

        $this->activityId = $viewData['activityDetails']['id'];
        $this->activityStartDate = $viewData['activityDetails']['date'];
        $this->activityStartTime = $viewData['activityDetails']['start_time'];
        $this->activityMeetingLink  = $viewData['activityDetails']['link'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $programCategory = ucfirst($this->programCategory);
        return new Envelope(
            from: new Address('no-reply@edu-all.com', 'No Reply'),
            subject: "Reminder: {$programCategory} Session Tomorrow."
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reminder.appointment',
            with: [
                'dear' => ucfirst($this->dear),
                'program_category' => $this->programCategory,
                'clients' => $this->clients,
                'activity' => [
                    'date' => $this->activityStartDate,
                    'time' => $this->activityStartTime,
                    'link' => $this->activityMeetingLink,
                ]
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
