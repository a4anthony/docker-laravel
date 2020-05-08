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

use App\MelaMart\Entities\Product;
use App\MelaMart\Entities\Image;
use App\MelaMart\Entities\ImageWebp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ImageResize;

/**
 * Products Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Gets post by Id
     *
     * @param int $productId 
     *
     * @return mixed
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($productId)
    {
        return Product::find($productId);
    }
    /**
     * Displays products on admin
     *
     * @param string $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function products($filter)
    {
        if ($filter == 'products.all') {
            return $this->all();
        } elseif ($filter == 'products.live') {
            return $this->live();
        } elseif ($filter == 'products.paused') {
            return $this->notLive();
        } elseif ($filter == 'products.out.of.stock') {
            return $this->noStock();
        } elseif ($filter == 'live') {
            return Product::where('live', 1);
        }
    }

    /**
     * Deletes post by Id
     *
     * @param int $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function delete($productId)
    {
        return Product::destroy($productId);
    }
    /**
     * Stores new product
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        request()->validate(
            [
                'barcode' => ['required', 'unique:products'],
                'title' => ['required', 'unique:products'],
                'brief_description' => 'required',
                //'features' => 'required',
                //'specification' => 'required',
                'image' => 'required',
                'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
                'main_category' => 'required',
                'sub_category' => 'required',
                'brand' => 'required',
                'initial_price' => 'required',
                'discount' => ['required', 'lte:100', 'gte:0'],
                'quantity' => 'required',
                'total_price' => 'required',
                'returns' => 'required',
                'delivery' => 'required'
            ]
        );


        $newProduct = new Product();
        $newProduct->barcode = request('barcode');
        $newProduct->title = request('title');
        $newProduct->slug = Str::slug(request('title'), '-');
        $newProduct->brief_description = request('brief_description');
        $newProduct->features = "not available";
        $newProduct->specifications =  "not available";
        $newProduct->main_category_id = request('main_category');
        $newProduct->sub_category_id = request('sub_category');
        $newProduct->brand = request('brand');
        $newProduct->initial_price = request('initial_price');
        $newProduct->discount = request('discount');
        $newProduct->quantity = request('quantity');
        $newProduct->total_price = request('total_price');
        $newProduct->returns = request('returns');
        $newProduct->delivery = request('delivery');
        $newProduct->save();

        $this->storeImage($request);
    }
    /**
     * Updates product details
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function productUpdate(Request $request)
    {
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        $url = str_replace('-', '.', $url);

        if ($url == 'product.status') {
            $product = Product::find($request->id);

            if ($product->live == 1) {
                Product::where('id', $request->id)->update(['live' => 0]);
                return;
            } elseif ($product->live == 0) {
                Product::where('id', $request->id)->update(['live' => 1]);
                return;
            }
        }
        if (Product::where('id', $request->id)->pluck('title')->first() != $request->title) {
            request()->validate(
                [
                    'title' => 'unique:products',
                ]
            );
        }
        if (Product::where('id', $request->id)->pluck('barcode')->first() != $request->barcode) {
            request()->validate(
                [
                    'barcode' => 'unique:products',
                ]
            );
        }
        request()->validate(
            [
                'barcode' => 'required',
                'title' => 'required',
                'brief_description' => 'required',
                //'features' => 'required',
                //'specification' => 'required',
                'main_category' => 'required',
                'sub_category' => 'required',
                'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
                'brand' => 'required',
                'initial_price' => 'required',
                'discount' => ['required', 'lte:100', 'gte:0'],
                'quantity' => 'required',
                'total_price' => 'required',
                'returns' => 'required',
                'delivery' => 'required'
            ]
        );

        Product::where('id', $request->id)->update(
            [
                'barcode' => $request->barcode,
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'brief_description' => $request->brief_description,
                //'features' => $request->features,
                //'specifications' => $request->specification,
                'main_category_id' => $request->main_category,
                'sub_category_id' => $request->sub_category,
                'brand' => $request->brand,
                'initial_price' => $request->initial_price,
                'discount' => $request->discount,
                'quantity' => $request->quantity,
                'total_price' => $request->total_price,
                'returns' => $request->returns,
                'delivery' => $request->delivery
            ]
        );

        if ($request->delImages != null) {
            $delImages = explode(',', $request->delImages);
            $currentImgCount = Image::where('product_id', $request->id)->count();

            if (count($delImages) == 1) {
                $this->checkImageNull($delImages, $currentImgCount, $request);
            }

            if (count($delImages) == 2) {
                $this->checkImageNull($delImages, $currentImgCount, $request);
            }

            if (count($delImages) == 3) {
                $this->checkImageNull($delImages, $currentImgCount, $request);
            }


            if ((count($delImages) == 4) && ($request->file('image') == null)) {
                $this->validateImage($request);
            } else {
                $this->storeImage($request);

                foreach ($delImages as $image) {
                    $this->delImage($request->id, $image);
                }
            }
        } else {
            $this->storeImage($request);
        }
    }
    /**
     * Gets products by slug
     *
     * @param string $productSlug 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function productBySlug($productSlug)
    {
        return Product::where([['slug', $productSlug], ['live', 1]])->firstOrFail();
    }
    /**
     * Retrives details of products in stock
     *
     * @param int $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getProductInStock($productId)
    {
        return Product::where(
            [
                ['id', $productId], ['quantity', '>', 0], ['live', 1]
            ]
        )->get();
    }
    /**
     * Retrives details of products out of stock
     *
     * @param int $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getProductNoStock($productId)
    {
        return Product::where([['id', $productId], ['quantity', 0], ['live', 1]])
            ->get();
    }
    /**
     * Retrieves product by id (firstOrFail)
     *
     * @param iny $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getProductFoF($productId)
    {
        return Product::where([['id', $productId], ['live', 1]])->firstOrFail();
    }
    /**
     * Run search queries
     *
     * @param string $searchInput 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function search($searchInput)
    {
        return Product::select('id', 'title', 'main_category_id', 'slug')
            ->where([['title', 'LIKE', '%' . $searchInput . '%'], ['live', 1]])
            ->limit(7)
            ->get();
    }
    /**
     * Search for product by title
     *
     * @param string $str 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchByTitle($str)
    {
        return Product::where([['title', 'LIKE', '%' . $str . '%'], ['live', 1]]);
    }
    /**
     * Search for item by category
     *
     * @param int $categoryId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchByCategory($categoryId)
    {
        return Product::where([['main_category_id', $categoryId], ['live', 1]]);
    }
    /**
     * Search for item by sub category
     *
     * @param int $categoryId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function searchBySubCategory($categoryId)
    {
        return Product::where([['sub_category_id', $categoryId], ['live', 1]]);
    }
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
    public function filterByPrice($categoryId, $int1, $int2, $pagNo, $categoryLevel)
    {
        if ($categoryLevel == null) {
            return Product::where(
                [
                    ['main_category_id', $categoryId],
                    ['live', 1]
                ]
            )->whereBetween('total_price', [$int1, $int2])->paginate($pagNo);
        } else {
            return Product::where(
                [
                    ['sub_category_id', $categoryId],
                    ['live', 1]

                ]
            )->whereBetween('total_price', [$int1, $int2])->paginate($pagNo);
        }
    }
    /**
     * Gets featured products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function featured()
    {
        return Product::where('live', true)
            ->limit(6)
            ->inRandomOrder()
            ->get();
    }
    /**
     * Gets new arrival products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newArrivals()
    {
        return Product::latest()
            ->where('live', true)
            ->limit(6)
            ->get();
    }
    /**
     * Gets best deals products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function bestDeals()
    {
        return Product::where('live', true)
            ->limit(6)
            ->orderBy('discount', 'desc')
            ->get();
    }
    /**
     * Count live products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countLive()
    {
        return Product::where('live', 1)->count();
    }
    /**
     * Count paused products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countNotLive()
    {
        return Product::where('live', 0)->count();
    }
    /**
     * Count out of stock products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countNoStock()
    {
        return Product::where('quantity', 0)->count();
    }
    /**
     * Count all products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countAll()
    {
        return Product::count();
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
     * Check if image will be null after update
     *
     * @param array                    $delImages 
     * @param int                      $currentImgCount 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function checkImageNull($delImages, $currentImgCount, Request $request)
    {
        if ((count($delImages) == $currentImgCount) && ($request->file('image') == null)) {
            $this->validateImage($request);
        } elseif (count($delImages) < $currentImgCount) {
            $this->storeImage($request);

            foreach ($delImages as $image) {
                $this->delImage($request->id, $image);
            }
        }
    }
    /**
     * Stores image in db
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function storeImage(Request $request)
    {
        $rand = date("YmdHis");
        if ($files = $request->file('image')) {
            // Define upload path
            $destinationPath = public_path('productImages/'); // upload path
            foreach ($files as $key => $img) {
                $imgSlug = Str::slug($request->title, '-');
                // Upload Orginal Image           
                $image = $imgSlug . '_' . ($key + 1) . $rand . '.' . $img->getClientOriginalExtension();
                $imageWebp = '/productImagesWebp/' . explode('.', $image)[0] . '.webp';
                $img->move($destinationPath, $image);
                // Save In Database
                $productId = Product::where('title', $request->title)
                    ->pluck('id')->first();
                $image = '/productImages/' . $image;
                //$this->deleteImagesBulk($image);
                if (!Image::where('image_link', $image)->exists()) {
                    $newImage = new Image();
                    $newImage->product_id = $productId;
                    $newImage->image_link = $image;
                    $newImage->save();

                    $newImage = new ImageWebp();
                    $newImage->product_id = $productId;
                    $newImage->image_link = $imageWebp;
                    $newImage->save();
                    $this->imageResize($image);
                    $this->imageToWebp($image);
                }
            }
        }
    }
    /**
     * Validates request if image will be null after update
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function validateImage(Request $request)
    {
        request()->validate(
            [
                'image' => 'required',
            ]
        );
    }
    /**
     * Deletes product image
     *
     * @param int    $productId 
     * @param string $imageLink 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function delImage($productId, $imageLink)
    {
        Image::where(
            [
                ['product_id', $productId],
                ['image_link', $imageLink]
            ]
        )->delete();
        $imageWebp = str_replace('/productImages', '/productImagesWebp',  explode('.', $imageLink)[0] . '.webp');
        ImageWebp::where(
            [
                ['product_id', $productId],
                ['image_link', $imageWebp]
            ]
        )->delete();
    }
    /**
     * Gets live products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function live()
    {
        $allProduct =  Product::where('live', 1)->latest()->get();
        if (count($allProduct) != 0) {
            return $allProduct;
        } else {
            $allProduct = [];
            return $allProduct;
        }
    }
    /**
     * Gets paused products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function notLive()
    {
        $allProduct = Product::where('live', 0)->latest()->get();
        if (count($allProduct) != 0) {
            return $allProduct;
        } else {
            $allProduct = [];
            return $allProduct;
        }
    }
    /**
     * Gets out of stock products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function noStock()
    {
        $allProduct = Product::where('quantity', 0)->latest()->get();
        if (count($allProduct) != 0) {
            return $allProduct;
        } else {
            $allProduct = [];
            return $allProduct;
        }
    }
    /**
     * Gets all products
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function all()
    {
        return Product::latest()->get();
    }
    /**
     * Image resizer
     *
     * @param string $imagePath 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function imageResize($imagePath)
    {
        $img = ImageResize::make(public_path('') . $imagePath);
        if ($img->height() != 400 && $img->width() != 400) {
            $img->resize(
                400,
                400
            )->save(public_path('') . $imagePath);
        }
    }
    /**
     * Image resizer
     *
     * @param string $imagePath 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function imageToWebp($imagePath)
    {
        $files = File::files(public_path('productImages/'));
        foreach ($files as $file) {
            if ('/productImages/' . $file->getRelativePathname() == $imagePath) {
                $imgName  = explode('.', $file->getRelativePathname())[0];
                ImageResize::make(public_path('') . $imagePath)
                    ->save(public_path('productImagesWebp/') . $file->getRelativePathname());
                shell_exec('cd ../ && cwebp -q 50 public/productImagesWebp/' . $file->getRelativePathname() . ' -o public/productImagesWebp/' . $imgName . '.webp');
                File::delete(public_path('productImagesWebp/') . $file->getRelativePathname());
            }
        }
    }
}
