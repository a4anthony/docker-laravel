<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Messages\MessageRepositoryInterface;

class MessagesController extends Controller
{
    protected $message;

    public function __construct(MessageRepositoryInterface $message)
    {
        $this->message = $message;
    }

    public function send(Request $request)
    {
        $this->message->newMessage($request);
        return redirect()->back()->with('success', 'Message sent');
    }
}
