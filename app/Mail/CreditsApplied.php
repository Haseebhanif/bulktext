<?php

namespace App\Mail;

use App\Http\Traits\EmailConfigSettingTrait;
use App\Models\PaymentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreditsApplied extends Mailable
{
    use Queueable;
    use SerializesModels;
    use EmailConfigSettingTrait;

    /**
     * The order instance.
     *
     * @var \App\Models\PaymentRecord
     */
    public $paymentRecord;
    public $branding;

    /**
     * The url instance.
     *
     */
    public $url;

    public $file;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentRecord,$branding, $file = null)
    {
        $this->branding = $branding;
        $this->paymentRecord = $paymentRecord;
        $this->url = env('app_url');
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.creditApplied');
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
            subject: 'Credits Applied',
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
            view: 'emails.orders.creditApplied',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if($this->file){
        return   [
            Attachment::fromStorageDisk('temp',$this->file)
                ->withMime('application/pdf')
        ];
        }

    }
}
