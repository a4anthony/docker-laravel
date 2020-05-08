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

use Illuminate\Http\Request;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Categories\CategoryRepositoryInterface;

/**
 * Password Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class SearchController extends Controller
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
    }
    /**
     * Returns search matches in json
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Http\Response 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function search(Request $request)
    {

        $searchInput = $request->search; //assigns search input from $request

        $results = $this->product->search($searchInput);
        $arrayResults = [];

        foreach ($results as $product) {
            $imageLink = $product->images[0]->image_link;
            $mainCategoryName = $product->mainCategory->name;

            $arrayResults[] = array(
                "id" => $product->id,
                'image' => $imageLink,
                "name" => $product->title,
                "category" => $mainCategoryName,
                "url" => $product->slug
            );
        }

        if ($request->ajax()) {
            return response()->json($arrayResults);
        } else {
            return view(
                'store.shop',
                [
                    'arrayProducts' => $results,
                    'url' => [],
                    'slugCat' => []

                ]
            );
        }
    }
    /**
     * Runs search query if form is submitted
     *     
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getsearch()
    {
        $pagNo = 24;
        if (isset($_GET['key'])) {
            $search = $_GET['key'];
            $str = $this->searchStr($search);
        }

        if ((isset($_GET['category']))  && (!isset($_GET['sub']))) {
            $range = null;
            //if result is filtered by amount
            if (isset($_GET['amount'])) {
                $range = $_GET['amount'];
            }
            $searchMainCategoryy = $_GET['category'];
            $searchSubCategory = "";
            return  $this->getCategory($searchMainCategoryy, $searchSubCategory, $range);
        }
        if (isset($_GET['sub'])) {
            $range = null;
            //if result is filtered by amount
            if (isset($_GET['amount'])) {
                $range = $_GET['amount'];
            }
            $searchSubCategory = $_GET['sub'];
            $searchMainCategoryy = $_GET['category'];
            return  $this->getCategory($searchMainCategoryy, $searchSubCategory, $range);
        }

        //if result is filtered by amount
        if (isset($_GET['amount'])) {
            $range = $_GET['amount'];
            return $this->filterProducts($range, $str, $search, $pagNo);
        }

        $products = $this->product->searchByTitle($str)->paginate($pagNo);
        $url = '/items/search?key=' . $search . '&'; //sets page url

        //if result is being sorted
        if (isset($_GET['sortby'])) {
            $sortby = $_GET['sortby'];
            $this->sortBy($sortby, $products);
        }

        return view(
            'store.shop',
            [
                'arrayProducts' => $products,
                'url' => $url,
                'slugCat' => ''

            ]
        );
    }
    /**
     * Filters by category
     *
     * @param string $slugMainCategory 
     * @param string $slugSubCategory 
     * @param int    $range 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCategory($slugMainCategory, $slugSubCategory, $range)
    {
        $pagNo = 24; //sets pagination number
        if ($slugSubCategory == null) {
            $category = $this->category->getCategoryByName($slugMainCategory);
            if ($slugMainCategory == "all") {
                $filter = 'live';
                $products = $this->product->products($filter);
            } else {
                $products = $category->products()->where('live', 1);
            }
            $url = '/items/search?category=' . $slugMainCategory . '&'; //sets page url

            if ($range != null) {
                $range_split = explode('-', $range);
                $int1 = (int) $range_split[0];
                $int2 = (int) $range_split[1];
                $products = $products->whereBetween('total_price', [$int1, $int2]);
                $url = '/items/search?category=' . $slugMainCategory . '&amount=' . $range . '&'; //sets page url
            }
        } else {
            $subCategory = $this->category->getSubCategoryByName($slugSubCategory);
            $products = $subCategory->products()->where('live', 1);
            $url = '/items/search?category=' . $slugMainCategory . '&sub=' . $slugSubCategory . '&'; //sets page url

            if ($range != null) {
                $range_split = explode('-', $range);
                $int1 = (int) $range_split[0];
                $int2 = (int) $range_split[1];
                $products = $products->whereBetween('total_price', [$int1, $int2]);
                $url = '/items/search?category=' . $slugMainCategory . '&sub=' . $slugSubCategory . '&amount=' . $range . '&'; //sets page url
            }
        }

        //if result is being sorted
        if (isset($_GET['sortby'])) {
            $sortby = $_GET['sortby'];
            //if result is being sorted
            if (isset($_GET['sortby'])) {
                $sortby = $_GET['sortby'];
                $this->sortBy($sortby, $products);
            }
        }

        return view(
            'store.shop',
            [
                'arrayProducts' => $products->paginate($pagNo),
                'url' => $url,
                'slugCat' => $slugMainCategory
            ]
        );
    }
    /**
     * Filters by price
     *
     * @param int    $range 
     * @param string $str 
     * @param string $search 
     * @param int    $pagNo 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function filterProducts($range, $str, $search, $pagNo)
    {
        $range_split = explode('-', $range);
        $int1 = (int) $range_split[0];
        $int2 = (int) $range_split[1];
        $products = $this->product->searchByTitle($str)
            ->whereBetween('total_price', [$int1, $int2]);
        $url = '/items/search?key=' . $search . '&amount=' . $range . '&'; //sets page url

        //if result is being sorted
        if (isset($_GET['sortby'])) {
            $sortby = $_GET['sortby'];
            $this->sortBy($sortby, $products);
        }

        return view(
            'store.shop',
            [
                'arrayProducts' => $products->paginate($pagNo),
                'url' => $url,
                'slugCat' => ''
            ]
        );
    }


    /**
     * -----------------------------------------------------------------------------------------
     * Controller Methods (BELOW)
     * -----------------------------------------------------------------------------------------
     * Here is where you can register methods for this controller. 
     * The methods here will be used to avoid code repitiotion 
     * and to simplify restful action above
     */



    /**
     * Sorts search results
     *
     * @param string $sortby  
     * @param mixed  $products 
     *
     * @return $products
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function sortBy($sortby, $products)
    {
        if ($sortby == 'relevant') {
            return $products = $products;
        } elseif ($sortby == 'high-to-low') {
            return $products = $products->orderBy('total_price', 'desc');
        } elseif ($sortby == 'low-to-high') {
            return $products = $products->orderBy('total_price', 'asc');
        }
    }
    /**
     * Formats search string
     *
     * @param string $search 
     *
     * @return $str
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchStr($search)
    {
        $strFilter1 = str_replace('+', ' ', $search); //converts slug to string[1]
        $strFilter2 = preg_replace('/[^a-zA-Z0-9]/', ' ', $strFilter1);
        $str = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $strFilter2)));  //converts slug to string[2]
        return $str;
    }
    /**
     * Gets sub category details
     *
     * @param int $subCategoryId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getSubCategory($subCategoryId)
    {

        if (!$subCategoryId) {
            //do nothing
        } else {
            $subcategory = $this->category->findSubCategory($subCategoryId);
        }

        return response()->json(['subCategory' => $subcategory]);
    }
}
