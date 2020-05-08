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

namespace App\Repositories\Products;

use Illuminate\Http\Request;

/**
 * Products Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface ProductRepositoryInterface
{
    /**
     * Gets post by Id
     *
     * @param int $productId 
     *
     * @return mixed
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($productId);
    /**
     * Displays products on admin
     *
     * @param string $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function products($filter);
    /**
     * Deletes post by Id
     *
     * @param int $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function delete($productId);
    /**
     * Stores new product
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request);
    /**
     * Updates product details
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function productUpdate(Request $request);
    /**
     * Gets products by slug
     *
     * @param string $productSlug 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function productBySlug($productSlug);
    /**
     * Retrives details of products in stock
     *
     * @param int $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getProductInStock($productId);
    /**
     * Retrives details of products out of stock
     *
     * @param int $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getProductNoStock($productId);
    /**
     * Retrieves product by id (firstOrFail)
     *
     * @param iny $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getProductFoF($productId);
    /**
     * Run search queries
     *
     * @param string $searchInput 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function search($searchInput);
    /**
     * Search for product by title
     *
     * @param string $str 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchByTitle($str);
    /**
     * Search for item by category
     *
     * @param int $categoryId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchByCategory($categoryId);
    /**
     * Search for item by sub category
     *
     * @param int $categoryId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchBySubCategory($categoryId);
    /**
     * Filters products by price
     *
     * @param int $categoryId 
     * @param int $int1 
     * @param int $int2 
     * @param int $pagNo 
     * @param int $categoryLevel  
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function filterByPrice($categoryId, $int1, $int2, $pagNo, $categoryLevel);
    /**
     * Gets featured products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function featured();
    /**
     * Gets new arrival products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newArrivals();
    /**
     * Gets best deals products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function bestDeals();
    /**
     * Count live products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countLive();
    /**
     * Count paused products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countNotLive();
    /**
     * Count out of stock products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countNoStock();
    /**
     * Count all products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countAll();
}
