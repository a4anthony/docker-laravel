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

namespace Tests\Feature;

use App\MelaMart\Entities\Address;
use App\MelaMart\Entities\Cart;
use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\Order;
use App\MelaMart\Entities\Product;
use App\MelaMart\Entities\SubCategory;
use App\MelaMart\Entities\Subscriber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Str;

/**
 * ProfilePage Test Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class ProfilePageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test class setUp
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
        $this->user = factory(User::class)->create();
        $this->url = env('APP_URL');
    }
    /**
     * User can't view profile if not logged in
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCannotViewProfileIfNotLoggedIn()
    {
        $response = $this->get($this->url . '/account');
        $response->assertRedirect($this->url . '/login');
    }
    /**
     * Logged in user can view cart items
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewProfileIfLoggedIn()
    {
        $user = $this->user;
        $this->signIn($user);
        $response = $this->get($this->url . '/account');
        $response->assertOK();
        $response->assertSee($user->email);
    }
    /**
     * User can view orders if empty
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testLoggedInUserCanViewOrdersIfEmpty()
    {
        $user = $this->user;
        $this->signIn($user);
        $response = $this->get($this->url . '/account/orders');
        $response->assertOK();
    }
    /**
     * Users can view wishlis if empty
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testLoggedInUserCanViewWishlistIfEmpty()
    {
        $user = $this->user;
        $this->signIn($user);
        $response = $this->get($this->url . '/account/wishlist');
        $response->assertOK();
    }
    /**
     * Users can view adddress if empty
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testLoggedInUserCanViewAddressIfEmpty()
    {
        $user = $this->user;
        $this->signIn($user);
        $response = $this->get($this->url . '/account/address-book');
        $response->assertOK();
    }
    /**
     * Users can edit details
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testLoggedInUserCanEditDetails()
    {
        $user = $this->user;
        $this->signIn($user);
        $response = $this->put($this->url . '/edit/details', ['firstname' => 'okon', 'lastname' => 'bassey', 'phone' => '08022228888']);
        $response->assertSessionHasNoErrors();
    }
    /**
     * Users can view orders
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewOrders()
    {
        $user = $this->user;
        $this->signIn($user);
        $category = $this->category;
        $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
        $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $reference1 = 'jfurirerejrr';
        $reference2 = 'jfuriressosksejrr';
        $reference3 = 'jfuriressosksdskokejrr';
        factory(Order::class)->create(['product_id' => $product1->id, 'user_id' => $user->id, 'reference' => $reference1]);
        factory(Order::class)->create(['product_id' => $product2->id, 'user_id' => $user->id, 'reference' => $reference2]);
        factory(Order::class)->create(['product_id' => $product3->id, 'user_id' => $user->id, 'reference' => $reference3]);
        $response = $this->get($this->url . '/account/orders');
        $response->assertSee($reference1);
        $response->assertSee($reference2);
        $response->assertSee($reference3);
    }
    /**
     * Users can view wishlist
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewWishlist()
    {
        $user = $this->user;
        $this->signIn($user);
        $category = $this->category;
        $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
        $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $reference1 = 'jfurirerejrr';
        $reference2 = 'jfuriressosksejrr';
        $reference3 = 'jfuriressosksdskokejrr';
        factory(Order::class)->create(['product_id' => $product1->id, 'user_id' => $user->id, 'reference' => $reference1]);
        factory(Order::class)->create(['product_id' => $product2->id, 'user_id' => $user->id, 'reference' => $reference2]);
        factory(Order::class)->create(['product_id' => $product3->id, 'user_id' => $user->id, 'reference' => $reference3]);
        $response = $this->get($this->url . '/account/wishlist');
        $response->assertSee($product1->title);
        $response->assertSee($product2->title);
        $response->assertSee($product3->title);
    }
    /**
     * Users can view address-book
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewAddress()
    {
        $user = $this->user;
        $this->signIn($user);
        $address1 = factory(Address::class)->create(['user_id' => $user->id]);
        $address2 = factory(Address::class)->create(['user_id' => $user->id]);
        $address3 = factory(Address::class)->create(['user_id' => $user->id]);

        $response = $this->get($this->url . '/account/address-book');
        $response->assertSee($address1->address_address);
        $response->assertSee($address2->address_address);
        $response->assertSee($address3->address_address);
    }
    /**
     * Users can add address
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanAddAddress()
    {
        $user = $this->user;
        $this->signIn($user);

        $response = $this->post(
            $this->url . '/account/add/address',
            [
                'address_number' => 'Plot 77', 'address_address' => 'oron road', 'address_latitude' => 5.949945, 'address_longitude' => 5.949945,
                'firstname' => 'okon', 'lastname' => 'bassey', 'phone' => '08022258888'
            ]
        );
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->url . '/account/address-book');
    }
    /**
     * Users can edit address
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanEditAddress()
    {
        $user = $this->user;
        $this->signIn($user);
        $address1 = factory(Address::class)->create(['user_id' => $user->id]);
        $address2 = factory(Address::class)->create(['user_id' => $user->id]);
        $address3 = factory(Address::class)->create(['user_id' => $user->id]);

        $response = $this->get($this->url . '/account/address-book/edit/' . $address1->address_id);
        $response->assertSee('Edit Address');


        $response = $this->put(
            $this->url . '/account/edit/address',
            [
                'address_number' => 'Plot 77', 'address_id' => $address1->address_id, 'address_address' => 'oron road', 'address_latitude' => 5.949945, 'address_longitude' => 5.949945,
                'firstname' => 'okon', 'lastname' => 'bassey', 'phone' => '08022258888'
            ]
        );
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->url . '/account/address-book');
    }
    /**
     * User can view change password form
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewChangePasswordForm()
    {
        $user = $this->user;
        $this->signIn($user);

        $response = $this->get($this->url . '/account/update/password');
        $response->assertOk();
        $response->assertSee('Old Password'); //CASE SENSITIVE
        $response->assertSee('New Password'); //CASE SENSITIVE
    }
    /**
     * User can change password
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanChangePassword()
    {
        $user = $this->user;
        $this->signIn($user);

        $response = $this->put($this->url . '/update/password', ['old_password' => 'password', 'password' => 'password1', 'password_confirmation' => 'password1']);
        $response->assertSessionHasNoErrors();
    }
    /**
     * Users can delete address
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanDeleteAddress()
    {
        $user = $this->user;
        $this->signIn($user);
        $address1 = factory(Address::class)->create(['user_id' => $user->id]);
        $address2 = factory(Address::class)->create(['user_id' => $user->id]);
        $address3 = factory(Address::class)->create(['user_id' => $user->id]);

        $response = $this->delete(
            $this->url . '/account/address-book/delete',
            [
                'address_id' => $address1->address_id
            ]
        );
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->url . '/account/address-book');
    }
    /**
     * User will be prompted to verify email address
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserShouldBeNotifiedToVerifyEmailAddress()
    {
        $user = factory(User::class)->create(['email_verified_at' => null]);
        $this->signIn($user);
        $response = $this->get($this->url . '/account');
        $response->assertSee('verify email');
    }
    /**
     * User can give feedback on orders
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanGiveFeedbackOnOrder()
    {
        $user = $this->user;
        $this->signIn($user);
        $category = $this->category;
        $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
        $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        $reference1 = 'jfurirerejrr';
        $reference2 = 'jfuriressosksejrr';
        $reference3 = 'jfuriressosksdskokejrr';
        factory(Order::class)->create(['product_id' => $product1->id, 'user_id' => $user->id, 'reference' => $reference1]);
        factory(Order::class)->create(['product_id' => $product2->id, 'user_id' => $user->id, 'reference' => $reference2]);
        factory(Order::class)->create(['product_id' => $product3->id, 'user_id' => $user->id, 'reference' => $reference3]);
        $response = $this->post($this->url . '//feedback/submit', ['feedback' => 'Nice one', 'product_id' => $product3->id]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->url . '/account/orders');
    }
}
