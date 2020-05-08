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

namespace App\Repositories\Subscribers;

use Illuminate\Http\Request;
use App\MelaMart\Entities\Subscriber;
use App\Rules\ValidateEmail;

/**
 * Subscribers Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class SubscriberRepository implements SubscriberRepositoryInterface
{
    /**
     * Save new subscriber email
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newSubscriber(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'unique:subscribers,email', 'regex:/gmail.com|yahoo.com/'],
            ]
        );
        $request->validate(
            [
                'email' => [new ValidateEmail()],
            ]
        );


        $new_subscriber = new Subscriber();
        $new_subscriber->email = $request->email;
        $new_subscriber->save();
    }
}
