<?php

use App\MelaMart\Entities\Image;
use App\MelaMart\Entities\ImageWebp;
use App\MelaMart\Entities\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as InterventionImages;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!File::exists('public/productImagesWebp/')) {
            File::makeDirectory('public/productImagesWebp/');
        }
        if (!File::exists('public/productImages/')) {
            File::makeDirectory('public/productImages/');
        }

        $products =  Product::all();
        $dirs = File::files(public_path('sampleImages/'));
        foreach ($products as $product) {
            foreach ($dirs as $key => $img) {
                $randomKey = rand(0, 30);
                $imgName = $dirs[$randomKey]->getRelativePathname();
                $ext = $dirs[$randomKey]->getExtension();
                if ($key < 1) {

                    $rand = $key . date("YmdHis");
                    InterventionImages::make('public/sampleImages/' . $imgName)
                        ->resize(400, 400)
                        ->save('public/productImages/' . $product->slug . '_' . $rand . '.' . $ext);

                    shell_exec('cwebp -q 50 public/productImages/' . $product->slug . '_' . $rand . '.' . $ext . ' -o public/productImagesWebp/' . $product->slug . '_' . $rand . '.webp');
                    // InterventionImages::make('public/sampleImages/' . $imgName)
                    //     ->resize(400, 400)
                    //     ->save('public/productImagesWebp/' . $product->slug . '_' . $rand . '.' . $ext);
                    factory(Image::class)->create(
                        [
                            'product_id' => $product->id,
                            'image_link' => '/productImages/' . $product->slug . '_' . $rand . '.' . $ext
                        ]
                    );
                    factory(ImageWebp::class)->create(
                        [
                            'product_id' => $product->id,
                            'image_link' => '/productImagesWebp/' . $product->slug . '_' . $rand . '.' . 'webp'
                        ]
                    );
                }
            }
        }
    }
}
