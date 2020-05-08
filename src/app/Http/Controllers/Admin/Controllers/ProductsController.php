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

namespace App\Http\Controllers\Admin\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Categories\CategoryRepositoryInterface;

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
    protected $product, $category;
    /**
     * Controller Construct
     *   
     * @param \App\Repositories\Products\ProductRepositoryInterface    $product 
     * @param \App\Repositories\Categories\CategoryRepositoryInterface $category 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(ProductRepositoryInterface $product, CategoryRepositoryInterface $category)
    {
        $this->product = $product;
        $this->category = $category;
        $this->middleware('authAdmin');
    }
    /**
     * Handle all index requests to controller
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request)
    {
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        $url = str_replace('-', '.', $url);
        $view = str_replace('.', '-', $url);
        $view = str_replace('products-', '', $view);

        $allProducts = $this->product->products($url);
        return view('admin.products.' . $view, ['allProducts' => $allProducts]);
    }
    /**
     * Gets product by Id
     *
     * @param int $productId 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function show($productId)
    {
        $product = $this->product->get($productId);

        return view(
            'admin.products.view',
            [
                'product' => $product,
            ]
        );
    }
    /**
     * Shows add item form
     *
     * @return view
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function create()
    {
        $allCategories = $this->category->allCategory();
        return view('admin.products.add', ['allCategories' => $allCategories]);
    }
    /**
     * Gets subcategory by main category Id
     *
     * @param int $mainCategoryId 
     *
     * @return Illuminate\Http\Response 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getSubCategory($mainCategoryId)
    {
        if (!$mainCategoryId) {
            $html = '<option value="">' . trans('global.pleaseSelect') . '</option>';
        } else {
            $html = '<option value="' . '">' . '--- Select Sub Category ---' . '</option>';
            $allSubCategories = $this->category->getSubCategory($mainCategoryId);

            foreach ($allSubCategories as $subcategory) {
                $html .= '<option value="' . $subcategory->id . '">' . $subcategory->name . '</option>';
            }
        }

        return response()->json(['html' => $html]);
    }
    /**
     * Stores new product in database
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        $this->product->store($request);
        return redirect()->route('allProducts')
            ->with('success', 'Item uploaded successfully');
    }
    /**
     * Updates product in database
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update(Request $request)
    {
        $this->product->productUpdate($request);

        return redirect('/product/' . $request->id)
            ->with('success', 'Item updated successfully');
    }
    /**
     * Shows product edit form
     *
     * @param int $productId 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function edit($productId)
    {
        $product = $this->product->get($productId);
        $imgLimit = 4 - count($product->images);
        return view(
            'admin.products.edit',
            [
                'product' => $product,
                'imgLimit' => $imgLimit
            ]
        );
    }
}
