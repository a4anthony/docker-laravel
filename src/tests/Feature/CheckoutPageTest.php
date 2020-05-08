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
use App\MelaMart\Entities\Invoice;
use App\MelaMart\Entities\SubCategory;
use App\MelaMart\Entities\Subscriber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Str;

/**
 * CheckoutPage Test Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class CheckoutPageTest extends TestCase
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
    public function testUserCannotViewCheckoutIfNotLoggedIn()
    {
        $response = $this->get($this->url . '/checkout');
        $response->assertRedirect($this->url . '/login');
    }
    /**
     * Logged in user can view cart items
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewCheckoutIfLoggedIn()
    {
        $user = $this->user;
        $this->signIn($user);
        $response = $this->get($this->url . '/checkout');
        $response->assertRedirect($this->url . '/cart');
    }
    /**
     * User can view checkout details
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewCheckOutDetails()
    {

        $category = $this->category;
        $user = $this->user;
        $this->signIn($user);

        $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
        $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50, 'sub_category_id' => $subCategory->id, 'live' => 1]);
        $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50, 'sub_category_id' => $subCategory->id, 'live' => 1]);
        $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50, 'sub_category_id' => $subCategory->id, 'live' => 1]);
        $product4 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50, 'sub_category_id' => $subCategory->id, 'live' => 1]);

        factory(Cart::class)->create(['product_id' => $product1->id, 'user_id' => $user->id, 'quantity' => 1]);
        factory(Cart::class)->create(['product_id' => $product2->id, 'user_id' => $user->id, 'quantity' => 5]);
        factory(Cart::class)->create(['product_id' => $product3->id, 'user_id' => $user->id, 'quantity' => 3]);
        factory(Cart::class)->create(['product_id' => $product4->id, 'user_id' => $user->id, 'quantity' => 9]);

        $address1 = factory(Address::class)->create(['user_id' => $user->id]);
        $address2 = factory(Address::class)->create(['user_id' => $user->id]);
        $address3 = factory(Address::class)->create(['user_id' => $user->id, 'address_address' => "33203 O'Keefe Ferry"]);

        $invoice1 = factory(Invoice::class)->create(
            [
                'user_id' => $user->id, 'invoice_id' => 'ffhbhfhfbfhdfd', 'status' => 'unpaid', 'first_name' => $user->firstname,
                'last_name' => $user->lastname, 'phone' => $user->phone, 'email' => $user->email, 'quantity' => 1,
                'product_id' => $product1->id, 'price' => $product1->total_price
            ]
        );
        $invoice2 =  factory(Invoice::class)->create(
            [
                'user_id' => $user->id, 'invoice_id' => 'ffhbhfhfbfhdfd', 'status' => 'unpaid', 'first_name' => $user->firstname,
                'last_name' => $user->lastname, 'phone' => $user->phone, 'email' => $user->email, 'quantity' => 5,
                'product_id' => $product2->id, 'price' => $product2->total_price
            ]
        );
        $invoice3 = factory(Invoice::class)->create(
            [
                'user_id' => $user->id, 'invoice_id' => 'ffhbhfhfbfhdfd', 'status' => 'unpaid', 'first_name' => $user->firstname,
                'last_name' => $user->lastname, 'phone' => $user->phone, 'email' => $user->email, 'quantity' => 3,
                'product_id' => $product3->id, 'price' => $product3->total_price
            ]
        );
        $invoice4 = factory(Invoice::class)->create(
            [
                'user_id' => $user->id, 'invoice_id' => 'ffhbhfhfbfhdfd', 'status' => 'unpaid', 'first_name' => $user->firstname,
                'last_name' => $user->lastname, 'phone' => $user->phone, 'email' => $user->email, 'quantity' => 9,
                'product_id' => $product4->id, 'price' => $product4->total_price
            ]
        );

        // $response = $this->post(
        //    $this->url . '/invoice',
        //    ['first_name' => $user->firstname, 'last_name' => $user->lastname, 'phone' => $user->phone, 'email' => $user->email, 'product_id' => $product1->id . ',' . $product2->id . ',' . $product3->id . ',' . $product4->id]
        // );
        //$response->assertSessionHasNoErrors();
        //$response->assertRedirect($this->url . '/checkout');

        $total = ($invoice1->price * $invoice1->quantity) + ($invoice2->price * $invoice2->quantity) + ($invoice3->price * $invoice3->quantity) + ($invoice4->price * $invoice4->quantity);
        $response = $this->get($this->url . '/checkout');
        $response->assertSee(e($address1->address_address));
        $response->assertSee(e($address2->address_address));
        $response->assertSee(e($address3->address_address));
        $response->assertSee($product1->title);
        $response->assertSee($product2->title);
        $response->assertSee($product3->title);
        $response->assertSee($product4->title);
        $response->assertSee($total);
    }
}
