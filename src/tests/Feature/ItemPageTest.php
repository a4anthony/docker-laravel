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
 * ItemPage Test Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class ItemPageTest extends TestCase
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
     * User can view single item
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testAUserCanViewSingleItemPage()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $response = $this->get($this->url . '/item/' . $product->slug);
                $response->assertSee($product->title);
            }
        );
    }
    /**
     * User can view item main category
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testAUserCanViewItemMainCategory()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $response = $this->get($this->url . '/item/' . $product->slug);
                $response->assertSee($this->category->name);
                $response->assertSee('/items/search?category=' . $category->slug);
            }
        );
    }
    /**
     * User can view item sub category
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testAUserCanViewItemSubCategory()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $response = $this->get($this->url . '/item/' . $product->slug);
                $response->assertSee($subCategory->name);
                $response->assertSee('/items/search?category=' . $category->slug . '&sub=' . $subCategory->slug);
            }
        );
    }
    /**
     * Products image displays
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testProductShouldDisplayImage()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $image = factory(Image::class)->create(['product_id' => $product->id]);
                $response = $this->get($this->url . '/item/' . $product->slug);
                $response->assertSee(env('IMAGE_URL') . $image->image_link);
            }
        );
    }
    /**
     * User can add item to cart
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanAddItemToCart()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);

                $response = $this->withCookie('melamart_session', 'bar')->post('/item/add-to-cart', ['product_id' => $product->id], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
                $response->assertJson(['msg' => 'Added to cart successfully']);
            }
        );
    }
    /**
     * User can add item to wishlist
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanAddItemToWishlist()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);

                $response = $this->withCookie('melamart_session', 'bar')->post('/item/add-to-wishlist', ['product_id' => $product->id], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
                $response->assertJson(['msg' => 'Added to wishlist successfully']);
            }
        );
    }
    /**
     * Logged in user can add item to cart
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testLoggedInUserCanAddItemToCart()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $this->signIn();
                $response = $this->post('/item/add-to-cart', ['product_id' => $product->id], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
                $response->assertJson(['msg' => 'Added to cart successfully']);
            }
        );
    }
    /**
     * Logged in user can add item to wishlist
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testLoggedInUserCanAddItemToWishlist()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $this->signIn();
                $response = $this->post('/item/add-to-wishlist', ['product_id' => $product->id], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
                $response->assertJson(['msg' => 'Added to wishlist successfully']);
            }
        );
    }
}
