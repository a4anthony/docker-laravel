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

use App\MelaMart\Entities\Cart;
use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\Image;
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
 * CartPage Test Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class CartPageTest extends TestCase
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
     * User can't view cart if not logged in
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCannotViewCartIfNotLoggedIn()
    {
        $response = $this->get($this->url . '/cart');
        $response->assertRedirect($this->url . '/login');
    }
    /**
     * Logged in user can view cart items
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewCartItemsIfLoggedIn()
    {
        $this->category->each(
            function ($category) {
                $user = $this->user;
                $this->signIn($user);
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product3->id, 'quantity' => 1]);
                $response = $this->get($this->url . '/cart');
                $response->assertSee($product1->title);
                $response->assertSee($product2->title);
                $response->assertSee($product3->title);
            }
        );
    }
    /**
     * User can adjust cart quantity
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanAdjustCartItemQuantity()
    {
        $this->category->each(
            function ($category) {
                $user = $this->user;
                $this->signIn($user);
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product3->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock3->id, 'quantity' => 1]);
                $quantity = 5;
                $totalInStock = ($product1->total_price * $quantity) + ($product2->total_price) + ($product3->total_price);

                $response = $this->put($this->url . '/cart/update/' . $product1->id . '/' . $quantity, ['product_id' => $product1->id], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
                $response->assertJson(['total' => number_format($product1->total_price * $quantity)]);
                $response->assertJson(['initialTotal' => number_format($product1->initial_price * $quantity)]);
                $response->assertSee(number_format($totalInStock));
            }
        );
    }
    /**
     * Out of stock cart items are excluded
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testCartItemsOutOfStockAreExcluded()
    {
        $this->category->each(
            function ($category) {
                $user = $this->user;
                $this->signIn($user);
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product3->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock3->id, 'quantity' => 1]);

                $total = ($product1->total_price) + ($product2->total_price) + ($product3->total_price) + ($productNoStock1->total_price) + ($productNoStock2->total_price) + ($productNoStock3->total_price);
                $totalInStock = ($product1->total_price) + ($product2->total_price) + ($product3->total_price);
                $response = $this->get($this->url . '/cart');
                $response->assertSee(number_format($totalInStock));
            }
        );
    }
    /**
     * User can delte items from cart
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanDeleteCartItem()
    {
        $this->category->each(
            function ($category) {
                $user = $this->user;
                $this->signIn($user);
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $product3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 50,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock1 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock2 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                $productNoStock3 = factory(Product::class)->create(['main_category_id' => $category->id, 'quantity' => 0,  'sub_category_id' => $subCategory->id, 'live' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $product3->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock1->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock2->id, 'quantity' => 1]);
                factory(Cart::class)->create(['user_id' => $user->id, 'product_id' => $productNoStock3->id, 'quantity' => 1]);

                $response = $this->delete($this->url . '/cart/delete/' . $product3->id);
                $response->assertRedirect($this->url . '/cart');
            }
        );
    }
}
