<?php

/**
 * PHP version 7.3
 * 
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  CVS: <1.0>
 * @link     https://melamartonline.com
 */

namespace App\Repositories\Messages;

use App\MelaMart\Entities\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessage;
use Illuminate\Http\Request;
use App\Rules\ValidateEmail;

/**
 * Message Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Gets messages
     *
     * @param string $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function message($filter)
    {
        $filter = explode('.', $filter);
        if ($filter[1] == 'all') {
            return Message::latest()->get();
        } elseif ($filter[1] == 'read') {
            return Message::where('status', 1)->latest()->get();
        } elseif ($filter[1] == 'unread') {
            return Message::where('status', 0)->latest()->get();
        }
    }
    /**
     * Gets all read Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function read()
    {
        return Message::where('status', 1)->latest()->get();
    }
    /**
     * Gets all unread Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function unread()
    {
        return Message::where('status', 0)->latest()->get();
    }
    /**
     * Gets message by Id
     *
     * @param int $messageId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getMessage($messageId)
    {
        Message::where('id', $messageId)->update(['status' => 1]);
        $message =  Message::find($messageId);
        return $message;
    }
    /**
     * Marks message unread
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function markUnread(Request $request)
    {
        Message::where('id', $request->message_id)->update(['status' => 0]);
    }
    /**
     * Deletes message
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function delete(Request $request)
    {
        Message::where('id', $request->message_id)->delete();
    }
    /**
     * Gets all messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function all()
    {
        return Message::latest()->get();
    }
    /**
     * New Message handler
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newMessage(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'regex:/gmail.com|yahoo.com/'],
                'name' => ['required'],
                'subject' => ['required'],
                'message' => ['required'],
            ]
        );
        $request->validate(
            [
                'email' => [new ValidateEmail()],
            ]
        );

        $newMesssage = new Message();
        $newMesssage->name = $request->name;
        $newMesssage->email = $request->email;
        $newMesssage->subject = $request->subject;
        $newMesssage->message = $request->message;
        $newMesssage->save();

        $message = request('message');
        $subject = request('subject');
        $email = request('email');
        $name = request('name');
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('h:ia');
        $title = 'MelaSpace Message';
        $template = 'Hello ' . $name . ',' . "\r\n\r\n" . '<--ENTER MESSAGE HERE-->' . "\r\n\r\n" . 'Cheers!' . "\r\n\r\n" . '- MelaMart' . "\r\n\r\n\r\n" . 'you wrote to us on ' . $date . ' at ' . $time . "\r\n" . '--------------------------------------------------' . "\r\n" . $message . "\r\n" . '--------------------------------------------------';
        Mail::to('info@melaspace.com')->send(new NewMessage($message, $subject, $name, $email, $template, $title));
    }
    /**
     * Count all read Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countRead()
    {
        return Message::where('status', 1)->count();
    }
    /**
     * Count all unread Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countUnread()
    {
        return Message::where('status', 0)->count();
    }
    /**
     * Count all messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countAll()
    {
        return Message::count();
    }
}
