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

namespace App\Http\Controllers;

use App\MelaMart\Entities\Product;
use App\Repositories\Products\ProductRepositoryInterface;

/**
 * Products Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class ProductsController extends Controller
{
    protected $product;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Products\ProductRepositoryInterface $product 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(ProductRepositoryInterface $product)
    {
        $this->product = $product;
    }
    public function index()
    {

        $results = Product::where('live', 1)->paginate(25);
        return view(
            'store.shop',
            [
                'arrayProducts' => $results,
                'url' => '',
                'slugCat' => ''

            ]
        );
    }
    /**
     * Displays  items details page
     *
     * @param string $productSlug 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function show($productSlug)
    {

        $product = $this->product->productBySlug($productSlug);
        $relatedProducts = $product->mainCategory->products->where('live', 1)->take(6);

        return view(
            'store.Item.item',
            [
                'product' => $product,
                'array_related_products' => $relatedProducts
            ]
        );
    }
}
