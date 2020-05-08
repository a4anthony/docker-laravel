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
use Illuminate\Database\Seeder;


/**
 * HomePage Test Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class HomePage extends TestCase
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
     * Homepge working
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get($this->url);
        $response->assertStatus(200);
    }
    /**
     * Redirects '/hoem to homepage
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testHomePageRedirect()
    {
        $response = $this->get($this->url . '/home');
        $response->assertRedirect($this->url);
    }
    /**
     * Can view live products
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewLiveProducts()
    {

        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
                $response = $this->get($this->url);
                $title = Str::substr($product->title, 0, 5);
                $response->assertSee($title)
                    ->assertSee($category->name);
            }
        );
    }
    /**
     * Cannot view paused products
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCannotViewPausedProducts()
    {
        $this->category->each(
            function ($category) {
                $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
                $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 0]);
                $response = $this->get($this->url);
                $title = Str::substr($product->title, 0, 5);
                $response->assertDontSee($title);
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
                $response = $this->get($this->url);
                $response->assertSee($image->image_link);
            }
        );
    }
    /**
     * Displays user name on log in
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserNameisDisplayedIfLoggedIn()
    {
        $user = $this->user;

        $this->signIn($user);

        $response = $this->get($this->url);
        $response->assertSee($user->firstname);
    }
    /**
     * Displays cart count
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testDisplayLoggedInUserCartCount()
    {
        $user = $this->user;
        $category = $this->category;
        $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
        $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1]);
        $cart = factory(Cart::class, 1)->create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 1]);

        $this->signIn($user);

        $response = $this->get($this->url);
        $response->assertSee(count($cart));
    }
    /**
     * Can view all categories
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCanViewAllCategories()
    {
        $category = $this->category;
        $response = $this->get($this->url);
        $response->assertSee($category->name);
    }
    /**
     * Cannot re-lgin if logged in
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCannotAttemptToLogInIfLoggedIn()
    {
        $this->signIn();

        $response = $this->get($this->url . '/login');
        $response->assertRedirect($this->url);
    }
    /**
     * Cannot re-register if registered
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCannotAttemptToRegisterIfLoggedIn()
    {
        $this->signIn();

        $response = $this->get($this->url . '/register');
        $response->assertRedirect($this->url);
    }
    /**
     * Cannot logout if not logged in
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testUserCannotAttemptToLogoutIfNotLoggedIn()
    {
        $response = $this->post($this->url . '/logout');
        $response->assertRedirect($this->url);
    }
    /**
     * User subscribtion requeires email
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testASubscriberRequiresAnEmail()
    {
        $this->newSubscriber(['email' => null])
            ->assertSessionHasErrors('email');
    }
    /**
     * User can subscribe
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testAUserCanSubscribe()
    {
        $this->newSubscriber(['email' => 'abc@gmail.com'])
            ->assertSessionHasNoErrors();
        $this->newSubscriber(['email' => 'abc@yahoo.com'])
            ->assertSessionHasNoErrors();
    }
    /**
     * User can subscribe with gmail or yahoo
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testAUserCanSubscribtionEmailShouldBeGmailOrEmail()
    {
        $this->newSubscriber(['email' => 'abc@null.com'])
            ->assertSessionHasErrors('email');
    }
    /**
     * User can search products
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function testAUserCanSearchProducts()
    {
        $category = $this->category;
        $subCategory = factory(SubCategory::class)->create(['category_id' => $category->id]);
        $product = factory(Product::class)->create(['main_category_id' => $category->id, 'sub_category_id' => $subCategory->id, 'live' => 1, 'title' => 'pppppppppppppp']);
        factory(Image::class)->create(['product_id' => $product->id]);

        $response = $this->post('/autocomplete', ['search' => 'p'], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertJson(["0" => ['name' => $product->title]]);
    }

    /**
     * -----------------------------------------------------------------------------------------
     * Test Class Methods (BELOW)
     * -----------------------------------------------------------------------------------------
     * Here is where you can register methods for this controller. 
     * The methods here will be used to avoid code repitiotion 
     * and to simplify restful action above
     */

    /**
     * Creates new subscriber
     *
     * @param array $overrides 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newSubscriber($overrides = [])
    {
        $subscriber = make(Subscriber::class, $overrides);
        return $this->post('/subscribe', $subscriber->toArray());
    }
}
