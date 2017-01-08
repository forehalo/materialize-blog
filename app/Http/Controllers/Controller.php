<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\PostRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * @var TagRepository
     */
    protected $tag;

    public function __construct(PostRepository $post, CategoryRepository $category, TagRepository $tag)
    {
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
    }

    /**
     * Blog index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('blog.index');
    }

    /**
     * Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard.index');
    }

    /**
     * Render sitemap.
     *
     * @return mixed
     */
    public function sitemap()
    {
        $sitemap = app('sitemap');

        $this->mapPosts($sitemap);
        $this->mapPages($sitemap);
        $this->mapCategories($sitemap);
        $this->mapTags($sitemap);
        
        return $sitemap->render('xml');
    }

    /**
     * Posts map
     *
     * @param $sitemap
     */
    private function mapPosts($sitemap)
    {
        $posts = $this->post->sitemaps();

        foreach ($posts as $post) {
            $sitemap->add(url('posts/'.$post->slug), $post->updated_at);
        }
    }

    /**
     * Pages map
     *
     * @param $sitemap
     */
    private function mapPages($sitemap)
    {
        $files = Storage::files('pages');

        foreach ($files as $file) {
            if (substr($file, -3) === '.md') {
                $sitemap->add(url(substr($file, 0, -3)));
            }
        }
    }

    /**
     * Categories map
     *
     * @param $sitemap
     */
    private function mapCategories($sitemap)
    {
        $categories = $this->category->all();
        
        foreach ($categories as $category) {
            $sitemap->add(url('categories/'.$category->name), $category->updated_at);
        }
    }

    /**
     * Tags map
     *
     * @param $sitemap
     */
    private function mapTags($sitemap)
    {
        $tags = $this->tag->all();
        
        foreach ($tags as $tag) {
            $sitemap->add(url('tags/'.$tag->name), $tag->updated_at);
        }
    }
}
