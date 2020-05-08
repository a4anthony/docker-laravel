<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete images from table & folder';

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
        //
    }
}
