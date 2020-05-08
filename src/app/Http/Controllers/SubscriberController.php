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

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Subscribers\SubscriberRepositoryInterface;

/**
 * Subscribers Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class SubscriberController extends Controller
{
    protected $subscriber;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Subscribers\SubscriberRepositoryInterface $subscriber 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(SubscriberRepositoryInterface $subscriber)
    {
        $this->subscriber = $subscriber;
    }
    /**
     * Saves subscriber's email in db
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        $this->subscriber->newSubscriber($request);
    }
}
