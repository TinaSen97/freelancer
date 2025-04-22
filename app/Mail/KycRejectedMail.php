<?php

namespace Fickrr\Mail;

use Fickrr\Models\Freelancer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KycRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $freelancer;

    public function __construct(Freelancer $freelancer)
    {
        $this->freelancer = $freelancer;
    }

    public function build()
    {
        return $this->subject('KYC Verification Requires Attention - Resubmission Needed')
                    ->view('emails.kyc_rejected');
    }
}