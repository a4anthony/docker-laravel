<?php

use App\MelaMart\Entities\Product;
use App\MelaMart\Entities\SubCategory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =  SubCategory::all();
        $categories->each(
            function ($category) {
                factory(Product::class, 1)->create(['main_category_id' => $category->category_id, 'sub_category_id' => $category->id]);
            }
        );
    }
}
