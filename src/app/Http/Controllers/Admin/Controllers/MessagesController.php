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

namespace App\Http\Controllers\Admin\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Messages\MessageRepositoryInterface;

/**
 * Messages Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class MessagesController extends Controller
{
    protected $message;

    /**
     * Controller Construct
     *
     * @param MessageRepositoryInterface $message 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(MessageRepositoryInterface $message)
    {
        $this->middleware('authAdmin');
        $this->message = $message;
    }
    /**
     * Handles index request
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request)
    {
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        $url = str_replace('-', '.', $url);
        //dd($url);
        $allMessages = $this->message->message($url);
        return view('admin.' . $url, ['allMessages' => $allMessages]);
    }

    /**
     * Retrieves message by Id
     *
     * @param int $messageId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function show($messageId)
    {
        $message = $this->message->getMessage($messageId);
        return view('admin.messages.view', ['message' => $message]);
    }
    /**
     * Sets message as unread
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update(Request $request)
    {
        $this->message->markUnread($request);
        return redirect()->route('unread');
    }
    /**
     * Delete message by Id
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function destroy(Request $request)
    {
        $this->message->delete($request);
        return redirect()->route('allMsg');
    }
}
