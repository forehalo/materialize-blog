<?php

namespace App\Console\Commands\Posts;

use App\Repositories\PostRepository;
use Exception;
use Illuminate\Console\Command;

class PostOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:one {name : The name of article wanted to be parsed.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post one article with given file name';

    protected $post;

    /**
     * Create a new command instance.
     *
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        parent::__construct();

        $this->storage = storage_path('app/posts');
        $this->post = $post;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $ext = strpos($name, '.md') ? '' : '.md';
        $filepath = storage_path('app/posts') . '/' . $name . $ext;

        try {
            $inputs = parseArticle($filepath);

            $res = $this->post->getByColumn($inputs['slug'], 'slug');

            if (is_null($res)) {
                $this->post->store($inputs);
                $this->info($name . ' parsed successfully!');
            } else {
                $this->post->update($inputs, $res->id);
                $this->info($name . ' updated successfully!');
            }

        } catch (Exception $e) {
            $this->error($name . ' parsed failed! Please check the syntax.', 10);
        }
    }
}
