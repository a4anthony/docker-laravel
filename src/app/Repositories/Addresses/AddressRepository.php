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
use App\MelaMart\Entities\Address;
use Illuminate\Support\Facades\Auth;

/**
 * Address Repository class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class AddressRepository implements AddressRepositoryInterface
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
     * Get address by Id
     *
     * @param int $addressId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function find($addressId)
    {
        return Address::find($addressId);
    }
    /**
     * Gets users saved
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getAddressBook($userId)
    {
        return Address::where('user_id', $userId)->get();
    }
    /**
     * Gets user address by Id
     *
     * @param int $userId 
     * @param int $addressId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getAddress($userId, $addressId)
    {
        return Address::where([['user_id', $userId], ['address_id', $addressId]])
            ->first();
    }
    /**
     * Check if address exists for user
     *
     * @param int $userId 
     * @param int $addressId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function addressExists($userId, $addressId)
    {
        return Address::where([['user_id', $userId], ['address_id', $addressId]])
            ->exists();
    }
    /**
     * Updates user address
     *
     * @param int                      $userId 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateAddress($userId, Request $request)
    {
        $userId = Auth::id();
        $addressId = $request->id;

        $request->validate(
            [
                'address_address' => ['required'],
                'address_id' => ['required'],
                'firstname' => ['required'],
                'lastname' => ['required'],
                'phone' => ['required', 'regex:/(0)[0-9]{10}/', 'max:11']
            ]
        );

        $request->validate(
            [
                'address_latitude' => ['required'],
                'address_longitude' => ['required']
            ]
        );


        Address::where([['user_id', $userId], ['address_id', $request->id]])
            ->update(
                [
                    'address_latitude' => $request->address_latitude,
                    'address_address' => $request->address_address,
                    'address_longitude' => $request->address_longitude,
                    'address_additional' => $request->address_additional,
                    'phone' => $request->phone,
                    'first_name' => $request->firstname,
                    'last_name' => $request->lastname,
                    'address_number' => $request->address_number
                ]
            );
    }
    /**
     * Adds new address for user
     * 
     * @param int                      $userId 
     * @param \Illuminate\Http\Request $request   
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function addAddress($userId, Request $request)
    {

        $request->validate(
            [
                'address_address' => ['required'],
                'firstname' => ['required'],
                'lastname' => ['required'],
                'phone' => ['required', 'regex:/(0)[0-9]{10}/', 'max:11']
            ]
        );

        $request->validate(
            [
                'address_latitude' => ['required'],
                'address_longitude' => ['required']
            ]
        );

        $add_address = new Address();
        $add_address->user_id = $userId;
        $add_address->first_name = $request->firstname;
        $add_address->last_name = $request->lastname;
        $add_address->phone = $request->phone;
        $add_address->address_number = $request->address_number;
        $add_address->address_address = $request->address_address;
        $add_address->address_additional = $request->address_additional;

        //increases user address id by 1
        if (Address::where('user_id', $userId)->exists()) {
            $getAddress = Address::where('user_id', $userId)->get();
            $count = count($getAddress);
            $add_address->address_id = $count + 1;
        } else {
            $add_address->address_id = 1;
        }
        $add_address->address_latitude = $request->address_latitude;
        $add_address->address_longitude = $request->address_longitude;
        $add_address->save();
    }
    /**
     * Deletes user address
     *
     * @param int                      $userId 
     * @param \Illuminate\Http\Request $request   
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteAddress($userId, Request $request)
    {
        $addressId = $request->address_id;
        Address::where([['address_id', $addressId], ['user_id', $userId]])->delete();
        $getAddress = Address::where(
            [
                ['address_id', '>', $addressId], ['user_id', $userId]
            ]
        )->get();

        foreach ($getAddress as $address) {
            Address::where(
                [
                    ['address_id', $address->address_id], ['user_id', $userId]
                ]
            )
                ->update(['address_id' => $address->address_id - 1]);
        }
    }
}
