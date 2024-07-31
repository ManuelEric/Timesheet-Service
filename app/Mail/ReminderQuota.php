<?php

namespace App\Mail;

use App\Http\Traits\PackageType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class ReminderQuota extends Mailable
{
    use Queueable, SerializesModels, PackageType;

    public $tries = 3; // Maximum number of retries
    public $title = 'Reminder Quota';

    public $timesheetId;
    protected $programCategory;
    protected $dear;
    protected $clients;
    protected $duration;

    /**
     * Create a new message instance.
     */
    public function __construct($viewData)
    {
        $this->afterCommit();

        [$this->programCategory, $tutor_or_mentor] = $this->convert($viewData['package']['category']);

        $this->timesheetId = $viewData['timesheet']->id;

        /* going to be send to the view */
        $this->dear = $viewData['package']['tutormentor_name'];
        $this->duration = round($viewData['package']['duration_in_minutes'] / 60, 2); # it should displayed as in hours
        $this->clients = implode(", ", array_map(function ($entry) {
            return $entry['client_name'];
        }, $viewData['clients']) );
    }

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            messageId: '',
            references: [''],
            text: [
                'X-MT-Category' => env('APP_NAME')
            ]
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $programCategory = ucfirst($this->programCategory);
        return new Envelope(
            from: new Address('no-reply@edu-all.com', 'No Reply'),
            subject: "Your session of {$programCategory} is Almost Up."
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reminder.quota',
            with: [
                'dear' => ucfirst($this->dear),
                'program_category' => $this->programCategory,
                'duration' => $this->duration,
                'clients' => $this->clients,
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
