<?php

namespace App\Console\Commands;

use App\MelaMart\Entities\Image as EntitiesImage;
use App\MelaMart\Entities\ImageWebp;
use App\MelaMart\Entities\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ToWebp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:webp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts images to webp';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $dirs = File::files(public_path('productImages/'));

        // foreach ($dirs as $img) {
        //     $path = 'public/productImages/' . $img->getRelativePathname();
        //     $fileName = $img->getRelativePathname();
        //     $ext = File::extension($path);
        //     $img = Image::make($path);

        //     if ($img->height() != 400 && $img->width() != 400) {
        //         $img->resize(
        //             400,
        //             400
        //         )->save('public/productImages/' . $fileName);
        //     }

        //     $allImages = EntitiesImage::all();
        //     foreach ($allImages as $img) {
        //         $checkPath = 'public' . $img->image_link;
        //         $imgSlug = Product::where('id', $img->product_id)->pluck('slug')->first() . '_1';
        //         if ($checkPath == $path) {
        //             Image::make($path)->save('public/productImages/' . $imgSlug . '.' . $ext);
        //             $newImg = new EntitiesImage();
        //             $newImg->product_id = $img->product_id;
        //             $newImg->image_link = '/productImages/' . $imgSlug . '.' . $ext;
        //             $newImg->save();
        //             $img->delete();

        //             if (!File::exists('public/productImagesWebp/')) {
        //                 File::makeDirectory('public/productImagesWebp/');
        //             }
        //             Image::make('public/productImages/' . $imgSlug . '.' . $ext)->save('public/productImagesWebp/' . $imgSlug . '.' . $ext);
        //             shell_exec('cwebp -q 50 public/productImagesWebp/' . $imgSlug . '.' . $ext . ' -o public/productImagesWebp/' . $imgSlug . '.webp');
        //             File::delete($path);
        //         }
        //     }
        // }
        // $img = Image::make('public/images/banner/8.jpg');
        // $img->resize(
        //     800,
        //     300
        // )->save('public/images/banner/8.jpg');
        // $img = Image::make('public/images/banner/2.jpg');
        // $img->resize(
        //     800,
        //     300
        // )->save('public/images/banner/2.jpg');

        // //to webp format
        // $images = [];
        // $dirs2 = File::files(public_path('productImagesWebp/'));
        // foreach ($dirs2 as $dir) {
        //     $path = 'public/productImagesWebp/' . $dir->getRelativePathname();
        //     $imgName = explode('.', $dir->getRelativePathname());
        //     $images[] = $dir->getRelativePathname();

        //     $allImages = EntitiesImage::all();
        //     foreach ($allImages as $img) {
        //         $imgSlug = Product::where('id', $img->product_id)->pluck('slug')->first() . '_1';
        //         if (!ImageWebp::where('product_id', $img->product_id)->exists() && !ImageWebp::where('image_link', '/productImagesWebp/' . $imgName[0] . '.webp')->exists()) {
        //             $newImg = new ImageWebp();
        //             $newImg->product_id = $img->product_id;
        //             $newImg->image_link = '/productImagesWebp/' . $imgSlug . '.webp';
        //             $newImg->save();
        //         }
        //     }

        //     if ($ext = File::extension($path) != 'webp') {
        //         File::delete($path);
        //     }
        // }
        $dirs = File::files(public_path('productImages/'));
        foreach ($dirs as $img) {
            $imgSlug = explode('.', $img->getRelativePathname())[0];
            $ext = $img->getExtension();
            Image::make('public/productImages/' . $imgSlug . '.' . $ext)->save('public/productImagesWebp/' . $imgSlug . '.' . $ext);
            shell_exec('cwebp -q 50 public/productImagesWebp/' . $imgSlug . '.' . $ext . ' -o public/productImagesWebp/' . $imgSlug . '.webp');


            if ($ext != 'webp') {
                File::delete('public/productImagesWebp/' . $imgSlug . '.' . $ext);
            }
        }
        dd('done');
    }
}
