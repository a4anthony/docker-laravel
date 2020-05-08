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

namespace App\Repositories\Addresses;

use Illuminate\Http\Request;

/**
 * Address Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface AddressRepositoryInterface
{

    /**
     * -------------------------------------------------
     * Index
     * -------------------------------------------------
     * 1. find($addressId);
     * 2. getAddressBook($userId);
     * 3. getAddress($userId, $addressId);
     * 4. addressExists($userId, $addressId);
     * 5. updateAddress($userId, Request $request);
     * 6. addAddress($userId, Request $request);
     * 7. deleteAddress($userId, Request $request);
     * -------------------------------------------------
     */

    /**
     * Gets adddress by Id
     *
     * @param int $addressId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function find($addressId);
    /**
     * Gets users saved
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getAddressBook($userId);
    /**
     * Gets user address by Id
     *
     * @param int $userId 
     * @param int $addressId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getAddress($userId, $addressId);
    /**
     * Check if address exists for user
     *
     * @param int $userId 
     * @param int $addressId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function addressExists($userId, $addressId);
    /**
     * Updates user address
     *
     * @param int                      $userId  
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateAddress($userId, Request $request);
    /**
     * Adds new address for user
     *
     * @param int                      $userId 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function addAddress($userId, Request $request);
    /**
     * Deletes user address
     *
     * @param int                      $userId 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteAddress($userId, Request $request);
}
