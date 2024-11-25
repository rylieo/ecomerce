<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;

    /**
     * Create a new message instance.
     *
     * @param int $otpCode
     * @return void
     */
    public function __construct(int $otpCode)
    {
        $this->otpCode = $otpCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.otp')
                    ->subject('Your OTP Code')
                    ->with([
                        'otpCode' => $this->otpCode,
                    ]);
    }
}
