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

namespace App\MelaMart\Entities;

use Illuminate\Database\Eloquent\Model;
use App\MelaMart\Entities\Image;
use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\SubCategory;
use App\MelaMart\Entities\Feedback;
use App\MelaMart\Entities\ImageWebp;

/**
 * Product Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '*'
    ];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(
            'images',
            function ($builder) {
                $builder->with('images');
            }
        );
        static::addGlobalScope(
            'mainCategory',
            function ($builder) {
                $builder->with('mainCategory');
            }
        );
        static::addGlobalScope(
            'subCategory',
            function ($builder) {
                $builder->with('subCategory');
            }
        );
        static::addGlobalScope(
            'feedback',
            function ($builder) {
                $builder->with('feedbacks');
            }
        );
    }
    /**
     * Gets product images
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }
    /**
     * Gets product images (webp format)
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function imagesWebp()
    {
        return $this->hasMany(ImageWebp::class, 'product_id');
    }
    /**
     * Gets product category
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function mainCategory()
    {
        return $this->hasOne(Category::class, 'id', 'main_category_id');
    }
    /**
     * Gets product sub category
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function subCategory()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }
    /**
     * Get product feedback
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'product_id');
    }
}
