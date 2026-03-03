<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GenericSystemNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $title;
    public $lines;
    public $actionText;
    public $actionUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($title, $lines = [], $actionText = null, $actionUrl = null)
    {
        $this->title = $title;
        $this->lines = $lines;
        $this->actionText = $actionText;
        $this->actionUrl = $actionUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.generic.notification',
            with: [
                'title' => $this->title,
                'lines' => $this->lines,
                'actionText' => $this->actionText,
                'actionUrl' => $this->actionUrl,
            ],
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
