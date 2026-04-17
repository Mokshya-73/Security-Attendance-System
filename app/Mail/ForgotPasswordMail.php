<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $resetUrl = url('/reset-password/' . $this->token);

        return $this->subject('Reset Your Password - Security System')
                    ->view('emails.forgot_password')
                    ->with([
                        'resetUrl' => $resetUrl,
                    ]);
    }
}
