<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Menggunakan route untuk memastikan URL sesuai dengan route yang terdaftar
        $verificationUrl = route('verification.verify', ['token' => $this->user->verification_token]);

        return $this->view('emails.verify-email')
            ->subject('Verify Your Email Address')
            ->with([
                'verificationUrl' => $verificationUrl,
            ]);
    }

}
