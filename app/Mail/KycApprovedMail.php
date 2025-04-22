<?php

namespace Fickrr\Mail;

use Fickrr\Models\Freelancer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KycApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $freelancer;

    public function __construct(Freelancer $freelancer)
    {
        $this->freelancer = $freelancer;
    }

    public function build()
    {
        return $this->subject('KYC Verification Approved - Full Access Granted')
                    ->view('emails.kyc_approved');
    }
}
