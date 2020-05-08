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

use Illuminate\Http\Request;

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
interface MessageRepositoryInterface
{
    /**
     * Gets messages
     *
     * @param string $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function message($filter);
    /**
     * Gets all read Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function read();
    /**
     * Gets all unread Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function unread();
    /**
     * Gets message by Id
     *
     * @param int $messageId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getMessage($messageId);
    /**
     * Marks message unread
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function markUnread(Request $request);
    /**
     * Deletes message
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function delete(Request $request);
    /**
     * Gets all messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function all();
    /**
     * New Message handler
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newMessage(Request $request);
    /**
     * Count all read Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countRead();
    /**
     * Count all unread Messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countUnread();
    /**
     * Count all messages
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countAll();
}
