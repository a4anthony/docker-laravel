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
use App\MelaMart\Entities\Product;

/**
 * Category Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class Category extends Model
{
    /**
     * Gets products that belong to category
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'main_category_id', 'id');
    }
    /**
     * Gets subcategories
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
