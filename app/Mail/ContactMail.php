<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $senderName;
    public string $senderEmail;
    public ?string $senderPhone;
    public string $service;
    public string $userMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $senderName,
        string $senderEmail,
        ?string $senderPhone,
        string $service,
        string $userMessage,
    ) {
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
        $this->senderPhone = $senderPhone;
        $this->service = $service;
        $this->userMessage = $userMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: "New Inquiry: " . $this->service);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: "emails.contact",
            with: [
                "senderName" => $this->senderName,
                "senderEmail" => $this->senderEmail,
                "senderPhone" => $this->senderPhone,
                "service" => $this->service,
                "userMessage" => $this->userMessage,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
