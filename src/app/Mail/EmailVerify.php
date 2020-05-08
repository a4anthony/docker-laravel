<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //q
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@melamartonline.com', 'MelaMart')
            ->subject('Verify your email address')
            ->view('store.emails.verifyemail')
            ->with(
                [
                    'customer_firstname' => $this->user->firstname,
                    'customer_lastname' => $this->user->lastname,
                    'customer_email' => $this->user->email,
                    'customer_token' => $this->user->token,
                ]
            );
    }
}
