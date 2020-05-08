<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\Products\ProductRepositoryInterface',
            'App\Repositories\Products\ProductRepository'
        );
        $this->app->bind(
            'App\Repositories\Orders\OrderRepositoryInterface',
            'App\Repositories\Orders\OrderRepository'
        );
        $this->app->bind(
            'App\Repositories\Transactions\TransactionRepositoryInterface',
            'App\Repositories\Transactions\TransactionRepository'
        );
        $this->app->bind(
            'App\Repositories\Messages\MessageRepositoryInterface',
            'App\Repositories\Messages\MessageRepository'
        );
        $this->app->bind(
            'App\Repositories\Users\UserRepositoryInterface',
            'App\Repositories\Users\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\Addresses\AddressRepositoryInterface',
            'App\Repositories\Addresses\AddressRepository'
        );
        $this->app->bind(
            'App\Repositories\Categories\CategoryRepositoryInterface',
            'App\Repositories\Categories\CategoryRepository'
        );
        $this->app->bind(
            'App\Repositories\Feedbacks\FeedbackRepositoryInterface',
            'App\Repositories\Feedbacks\FeedbackRepository'
        );
        $this->app->bind(
            'App\Repositories\Carts\CartRepositoryInterface',
            'App\Repositories\Carts\CartRepository'
        );
        $this->app->bind(
            'App\Repositories\GuestCarts\GuestCartRepositoryInterface',
            'App\Repositories\GuestCarts\GuestCartRepository'
        );
        $this->app->bind(
            'App\Repositories\Wishlists\WishlistRepositoryInterface',
            'App\Repositories\Wishlists\WishlistRepository'
        );
        $this->app->bind(
            'App\Repositories\GuestWishlists\GuestWishlistRepositoryInterface',
            'App\Repositories\GuestWishlists\GuestWishlistRepository'
        );
        $this->app->bind(
            'App\Repositories\GuestCookies\GuestCookieRepositoryInterface',
            'App\Repositories\GuestCookies\GuestCookieRepository'
        );
        $this->app->bind(
            'App\Repositories\Invoices\InvoiceRepositoryInterface',
            'App\Repositories\Invoices\InvoiceRepository'
        );
        $this->app->bind(
            'App\Repositories\Subscribers\SubscriberRepositoryInterface',
            'App\Repositories\Subscribers\SubscriberRepository'
        );
    }
}
