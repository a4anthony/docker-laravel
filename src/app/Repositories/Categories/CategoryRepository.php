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

namespace App\Repositories\Categories;

use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\SubCategory;

/**
 * Category Repository class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Gets all categories
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function allCategory()
    {
        return Category::all();
    }
    /**
     * Gets product subcategory
     *
     * @param int $mainCategoryId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getSubCategory($mainCategoryId)
    {
        return SubCategory::where('category_id', $mainCategoryId)->get();
    }
    /**
     * Gets category by name
     *
     * @param string $slugMainCategory 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCategoryByName($slugMainCategory)
    {
        return Category::where('slug', $slugMainCategory)->first();
    }
    /**
     * Gets sub category by name
     *
     * @param string $slugSubCategory 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getSubCategoryByName($slugSubCategory)
    {
        return SubCategory::where('slug', $slugSubCategory)->first();
    }
    /**
     * Finds sub category
     *
     * @param int $subCategoryId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function findSubCategory($subCategoryId)
    {
        return SubCategory::find($subCategoryId);
    }
}
