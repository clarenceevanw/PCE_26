<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoScheduleAvailable extends Mailable implements ShouldQueue
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
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Applicant Belum Mendapat Jadwal Wawancara')
                    ->view('mail.no_schedule_available_admin')
                    ->with([
                        'link' => route('admin.home'),
                        'applicant' => $this->applicant
                    ]);
    }
}
