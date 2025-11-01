<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderIsiJadwal extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $applicant;
    /**
     * Create a new message instance.
     */
    public function __construct($applicant)
    {
        $this->applicant = $applicant;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Reminder Isi Jadwal Wawancara')
                    ->view('mail.reminder')
                    ->with([
                        'link' => route('applicant.jadwal'),
                        'applicant' => $this->applicant
                    ]);
    }
}
