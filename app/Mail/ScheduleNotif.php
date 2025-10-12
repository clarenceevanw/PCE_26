<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduleNotif extends Mailable
{
    use Queueable, SerializesModels;

    public $hari;
    public $tanggal;
    public $jam;
    public $link_gmeet;

    public function __construct($data)
    {
        $this->hari = $data['hari'];
        $this->tanggal = $data['tanggal'];
        $this->jam = $data['jam'];
        $this->link_gmeet = $data['link_gmeet'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Jadwal Wawancara',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.scheduleMail',
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
