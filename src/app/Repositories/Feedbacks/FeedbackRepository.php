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

namespace App\Repositories\Feedbacks;

use Illuminate\Http\Request;
use App\MelaMart\Entities\Feedback;

/**
 * Feedback Repository class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * Saves item feedback in database
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function addFeedback(Request $request)
    {
        request()->validate(
            [
                'feedback' => ['required', 'string', 'max:255'],
            ]
        );

        $newFeedback = new Feedback();
        $newFeedback->product_id = $request->product_id;
        $newFeedback->feedback = $request->feedback;
        $newFeedback->save();
    }
}
