<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PullGit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull from git';

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
        $output = shell_exec('git pull https://' . env('GIT_ACCESS') . '@github.com/a4anthony/melamart-store.git');
        dd($output);
    }
}
