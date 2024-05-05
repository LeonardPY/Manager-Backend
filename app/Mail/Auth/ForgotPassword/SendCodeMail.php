<?php

namespace App\Mail\Auth\ForgotPassword;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCodeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private object $resetPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(object $resetPassword)
    {
        $this->resetPassword = $resetPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->subject('Your Code')
            ->view('emails.forgot_password.forgot_password_code')->with([
                'email' => $this->resetPassword->email,
                'code' => $this->resetPassword->code
            ]);
    }
}
