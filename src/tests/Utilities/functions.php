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

/**
 * Creates dummy data
 *
 * @param model $class 
 * @param array $attributes 
 * @param int   $times 
 *
 * @return void
 * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
 */
function create($class,  $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}
/**
 * Makesdummy data
 *
 * @param model $class 
 * @param array $attributes 
 * @param int   $times 
 *
 * @return void
 * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
 */
function make($class,  $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}
