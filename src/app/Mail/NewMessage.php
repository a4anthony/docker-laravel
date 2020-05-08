<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $subject, $name, $email, $template, $title)
    {
        //
        $this->message = $message;
        $this->email = $email;
        $this->subject = $subject;
        $this->name = $name;
        $this->template = $template;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('messages@melaspace.com', $this->title)
            ->subject($this->subject)
            ->view('store.emails.newmessage')
            ->with([
                'message_content' => $this->message,
                'email' => $this->email,
                'name' => $this->name,
                'subject' => $this->subject,
                'template' => $this->template,
            ]);
    }
}
