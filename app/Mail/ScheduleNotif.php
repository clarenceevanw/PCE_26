<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduleNotif extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $hari;
    public $tanggal;
    public $jam;
    public $isOnline;
    public $lokasi;
    public $link_gmeet;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->hari = $data['hari'];
        $this->tanggal = $data['tanggal'];
        $this->jam = $data['jam'];
        $this->isOnline = $data['isOnline'];
        $this->lokasi = $data['lokasi'];
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
