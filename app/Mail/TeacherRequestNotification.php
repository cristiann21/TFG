<?php

namespace App\Mail;

use App\Models\TeacherRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeacherRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $teacherRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(TeacherRequest $teacherRequest)
    {
        $this->teacherRequest = $teacherRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Teacher Request Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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

    public function build()
    {
        return $this->markdown('emails.teacher-request')
                    ->subject('Nueva Solicitud de Profesor - PinCode');
    }
}
