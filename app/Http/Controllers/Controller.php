<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Repositories\CaptchaRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function captcha(CaptchaRepository $captcha)
    {
        $captcha->captcha();
    }

    public function sitemap()
    {
        $sitemap = App::make('sitemap');

        if (!$sitemap->isCached()) {
            $posts = Post::select('slug', 'view_count','updated_at')->orderBy('created_at', 'desc')->get();
            $pages = Page::select('slug', 'updated_at')->get();

            foreach ($posts as $post) {
                $sitemap->add(url('/posts') . '/' . $post->slug, $post->updated_at);
            }

            foreach ($pages as $page){
                $sitemap->add(url('/') . '/' . $page->slug, $page->updated_at);
            }
        }
        
        return $sitemap->render();
    }

    public function about()
    {
        return view('front.pages.about');
    }
}
