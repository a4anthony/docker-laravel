<?php

use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainCategory = [
            'Body Care' => ['Shaving Blade', 'After Shave', 'Shaving Foam', 'Body Cream', 'Body Lotion', 'Body Oil', 'Roll On', 'Body Spray', 'Perfumes'],
            'Bath Care' => ['Antiseptic Soaps', 'Bath Soaps', 'Bath Wash', 'Powder', 'Face & Body Scrub', 'Bath Salt'],
            'Skin Care' => ['SPF', 'Facial Soap/Wash', 'Facial Toner', 'Facial Cream', 'Facial Wipes', 'Facial Pads/Cotton Wool', 'Cotton Buds'],
            'Feminine Care' => ['Towels, Liner & Tampax', 'Feminine Wash'],
            'Dental Care' => ['Toothpaste', 'Children Toothpaste', 'Mouthwash', 'Toothbrush'],
            'Hair Care' => ['Shampoo', 'Conditioner', 'Relaxer', 'Hair Cream', 'Hair Gel & Edge Control', 'Hair Dye', 'Hair Accessories', 'Hair Brush/Comb'],
            'Makeup $ Nails' => ['Nail Care', 'Face Powder'],
            'Baby Care' => ['Baby Cream', 'Baby Lotion', 'Baby Powder', 'Baby Oil', 'Baby Soap', 'Baby Cotton & Baby Wipes', 'Baby Diapers', 'Baby Swabs', 'Baby Food'],
            'Drinks, Juice & Water' => ['Water', 'Soft Drinks', 'Juice', 'Energy Drinks', 'Non Alcholic Drinks', 'Liqour', 'Wine', 'Beer, Cider & Ale'],
            'Food Cupboard' => ['Biscuit', 'Chocolates', 'Sweet & Gum', 'Crisps', 'Nuts', 'Custard', 'Cereal', 'Jam & Spread', 'Honey', 'Sugar/Sweetner', 'Noodles', 'Spaghetti', 'Easycook Meals', 'Evaporated Milk', 'Powdered Milk', 'Tinned Milk', 'Butter & Yoghurt', 'Bread'],
            'Spice & Sauce' => ['Salt', 'Seasoning', 'Sauces & Tomato Paste', 'Apple Cider Vinegar', 'Oil'],
            'Canned Food' => ['Canned Meat', 'Canned Fish', 'Canned Vegetables'],
            'Household' => ['Bleach, Toilet & Disinfectants', 'Hand Sanitizer', 'Hand Wash', 'Wahing Up Liquid', 'Repellants', 'Detergents', 'Air Freshners', 'Kitchen & Toilet', 'Bags & Storage', 'Serviette/Tissue', 'Shoe Polish', 'Umbrella', 'Light & Battery'],
            'Kitchen Ware' => ['Cups, Mugs & Bottles', 'Wine Opener', 'Lunch Boxes & Flask', 'Pot & Plates', 'Cutlery, Racks & Boards', 'Toothpick & Straws', 'Matches & Lighter'],
            'Stationery' => ['Pen, Pencil & Ruler', 'Envelope, Tapes & Scissors', 'Calculators & Mathsets', 'Notebook & Files', 'Decorations', 'Gift Items', 'Playing Cards & Jump Ropes'],
        ];

        foreach ($mainCategory as $key => $category) {
            $categories =  factory(Category::class)->create(['name' => $key, 'slug' => Str::slug($key, '-')]);

            foreach ($category as $subCategory) {
                factory(SubCategory::class)->create(['category_id' => $categories->id, 'name' => $subCategory, 'slug' => Str::slug($subCategory, '-')]);
            }
        }
    }
}
