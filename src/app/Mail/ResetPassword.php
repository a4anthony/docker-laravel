<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $link)
    {
        //
        $this->user = $user;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@melamartonline.com', 'MelaMart')
            ->subject('Password Reset')
            ->view('store.emails.passwordreset')
            ->with(
                [
                    'customer_firstname' => $this->user->firstname,
                    'reset_link' => $this->link,
                ]
            );
    }
}
