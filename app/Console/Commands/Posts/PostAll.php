<?php

namespace App\Console\Commands\Posts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PostAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post all articles exist in storage folder.';

    /**
     * Create a new command instance.
     *
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
        $files = Storage::files('posts');

        foreach ($files as $file) {
            $this->call('post:one', ['name' => substr($file, 6)]);
        }
    }
}
