<?php

namespace App\Mail;

use App\Http\Traits\EmailConfigSettingTrait;
use App\Models\EmailService;
use App\Models\ImportReview;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ImportProcessed extends Mailable
{
    use Queueable;
    use SerializesModels;
    use EmailConfigSettingTrait;

    public $team;
    public $email;
    public $branding;
    public $tenantName;
    public $importInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team,$email,$tenant_id,$tenantName,$branding)
    {
        $this->email = $email;
        $this->team = $team;
        $this->branding =  $branding;

        $this->tenantName =  $tenantName;
        $this->importInfo = ImportReview::where('team_id',$team)->first();
        $this->switchMailSettings($tenant_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {


        $result =  $this->email;
        $fromEmail = $result ? $this->email : env('MAIL_FROM_ADDRESS');
        $fromName=   $this->branding->tenant_name;

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            subject: 'Import Processed',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.import.imported');
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.import.imported',
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


    private function switchMailSettings($tenant_id){


        $tenant =    EmailService::where('tenant_id',$tenant_id)->first();


            if($tenant){
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.host', $tenant->smtp);
                Config::set('mail.mailers.smtp.port', $tenant->port);
                Config::set('mail.mailers.smtp.encryption', $tenant->encryption);
                Config::set('mail.mailers.smtp.username', $tenant->username);
                Config::set('mail.mailers.smtp.password', decrypt($tenant->password));
                Config::set('mail.from.address', $tenant->email);
                Config::set('mail.from.name', $tenant->name);

                config('mail.default', 'smtp');
                config('mail.mailers.smtp.host', $tenant->smtp);
                config('mail.mailers.smtp.port', $tenant->port);
                config('mail.mailers.smtp.encryption', $tenant->encryption);
                config('mail.mailers.smtp.username', $tenant->username);
                config('mail.mailers.smtp.password', decrypt($tenant->password));
                config('mail.from.address', $tenant->email);
                config('mail.from.name', $tenant->name);

                config()->set([

                    'mail.default'=>'smtp',
                    'mail.mailers.smtp.host' =>   $tenant->smtp,
                    'mail.mailers.smtp.port' =>  $tenant->port,
                    'mail.mailers.smtp.encryption' => $tenant->encryption,
                    'mail.mailers.smtp.username' => $tenant->username,
                    'mail.mailers.smtp.password' => decrypt($tenant->password),
                    'mail.from.address' => $tenant->email,
                    'mail.from.name'=>$tenant->name
                ]);
            }
}

}
