<?php

namespace App\Mail;

use App\Http\Traits\EmailConfigSettingTrait;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserEmail extends Mailable
{
    use Queueable, SerializesModels,EmailConfigSettingTrait;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public User $user;
    public $subject;
    public $markdown;

    public function __construct(User $user)
    {

        $this->user = $user;
        $this->subject = 'New User Added to ' . $this->user->currentTeam->company->company_name;
        $this->markdown = 'emails.newuser.added';

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {

        $result =   $this->checkCustomEmail();
        $branding = $this->emailBranding();
        $fromEmail = $result ? $result->email: env('MAIL_FROM_ADDRESS');
        $fromName=  $result ? $result->name : $branding->tenant_name;

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            subject:  $this->subject,
        );

    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.newuser.added',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
