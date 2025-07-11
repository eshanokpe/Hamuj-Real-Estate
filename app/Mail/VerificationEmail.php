<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $referralLink;
    public $virtualAccountData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $referralLink,$virtualAccountData )
    {
        $this->user = $user;
        $this->referralLink = $referralLink;
        $this->virtualAccountData = $virtualAccountData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() 
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
        ); 
        return $this->from('info@rabmotlicensing.com', 'Dohmayn')
        ->subject('Notification Email - Dohmayn')
        ->markdown('emails.verify-email')->with([
            'first_name' => $this->user->first_name, 
            'last_name' => $this->user->last_name, 
            'user_id' => $this->user->id, 
            'referralCode' => $this->referralLink, 
            'verifyUrl' => $verificationUrl,

            'bankName' => $this->virtualAccountData['bank']['name'],
            'accountName' => $this->virtualAccountData['account_name'],
            'accountNumber' => $this->virtualAccountData['account_number'],
            'currency' => $this->virtualAccountData['currency'],
            'customerCode' => $this->virtualAccountData['customer']['customer_code'],
        ]);
    }
}