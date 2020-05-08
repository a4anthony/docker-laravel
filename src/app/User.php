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

namespace App;

use App\MelaMart\Entities\Address;
use App\MelaMart\Entities\Invoice;
use App\MelaMart\Entities\Wishlist;
use App\MelaMart\Entities\Order;
use App\MelaMart\Entities\PasswordReset;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * User ModelClass
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'password', 'is_admin', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Updates user details
     *
     * @param query                    $query 
     * @param int                      $userId 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function scopeuserUpdate($query, $userId, Request $request)
    {
        request()->validate(
            [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'regex:/(0)[0-9]{10}/'],
            ]
        );
        User::where('id', $userId)->update(
            [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
            ]
        );
    }
    /**
     * Changes user password
     *
     * @param query                    $query 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function scopechangePassword($query, Request $request)
    {
        $request->validate(
            [
                'old_password' => ['required', new MatchOldPassword],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
        $new_password = $request->password;
        User::find(auth()->user()->id)->update(['password' => Hash::make($new_password)]);
    }
    /**
     * Reset user password
     *
     * @param query                    $query 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function scoperesetPassword($query, Request $request)
    {
        $email = PasswordReset::where('token', $request->token)->pluck('email')->first();
        $request->validate(
            [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
        $new_password = $request->password;
        User::where('email', $email)
            ->update(['password' => Hash::make($new_password)]);
    }
    /**
     * Handles email verification
     *
     * @param query  $query 
     * @param int    $userId 
     * @param string $token 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function scopeemailVerify($query, $userId, $token)
    {
        $currentTime = Carbon::now();
        User::where([['token', $token], ['id', $userId]])->update(['email_verified_at' => $currentTime]);
    }
    /**
     * Retrieves user address
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    /**
     * Retrieves user address
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function address($user, $addressId)
    {
        $address = Address::where([['user_id', $user->id], ['address_id', $addressId]])
            ->first();
        return $address->number . ' ' . $address->address_address;
    }
    /**
     * Retrieves user wishlist items
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }
    /**
     * Retrieves user orders
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    /**
     * Retrieves a single user order
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'user_id');
    }
    /**
     * Retrives user invoice
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }
}
