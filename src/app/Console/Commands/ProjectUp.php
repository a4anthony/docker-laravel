<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ProjectUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up project in one coomand';

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
        //return phpinfo();

        if (env('APP_ENV') == 'local') {
            if (File::exists('public/productImagesWebp/')) {
                File::deleteDirectory('public/productImagesWebp/');
            }
            if (File::exists('public/productImages/')) {
                File::deleteDirectory('public/productImages/');
            }
            dump('project setup is running. Please wait for a few minutes...');
            dump('...with love from Tony :)');
            $output =  shell_exec('php artisan key:generate && php artisan migrate && php artisan migrate:refresh && php artisan db:seed');
            dd($output);
        } else {
            dd("sorry, this will not run in production");
        }
    }
}
