<?php

namespace App\Mail;

use App\Http\Traits\EmailConfigSettingTrait;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class Welcome extends Mailable
{
    use Queueable, SerializesModels,EmailConfigSettingTrait;

    public $branding;
    public $url;
    public $logo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($branding)
    {

        $this->branding = $branding;
        $this->url = $branding->istld ? 'https://'.$branding->domain : 'https://'.$branding->domain.'.'.env('DOMAIN');
        $this->logo = asset( $branding->logo ?? $this->url.'/logo.png');


    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {

       $result =   $this->checkCustomEmail();
       $fromEmail = $result ? $result->email: env('MAIL_FROM_ADDRESS');
       $fromName=  $result ? $result->name : $this->branding->tenant_name;

         return new Envelope(
                from: new Address($fromEmail, $fromName),
                subject: 'Welcome from '.$this->branding->tenant_name,
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
            view: 'emails.welcome',
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
