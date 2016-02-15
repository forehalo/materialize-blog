<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    /**
     * Dashboard index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $postsCount = Post::count();
        $commentsCount = Comment::whereSeen(0)->count();
        return view('back.index', compact('postsCount', 'commentsCount'));
    }

    /**
     * Setting page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setting()
    {
        return view('back.settings.setting');
    }
}
