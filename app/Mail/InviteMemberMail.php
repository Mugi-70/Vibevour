<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteMemberMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $groupName;
    public $inviteLink;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $groupName, $inviteLink)
    {
        $this->email = $email;
        $this->groupName = $groupName;
        $this->inviteLink = $inviteLink;
    }

    public function build()
    {
        return $this->subject("Undangan Bergabung ke Grup $this->groupName")
            ->view('emails.invite_member')
            ->with([
                'email' => $this->email,
                'groupName' => $this->groupName,
                'inviteLink' => $this->inviteLink
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Grup',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

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
