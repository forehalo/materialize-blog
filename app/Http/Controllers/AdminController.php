<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{

    /**
     * @var AdminRepository
     */
    protected $admin;

    /**
     * AdminController constructor.
     * @param AdminRepository $admin
     */
    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }

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
        $config = $this->admin->blogConfig();
        return view('back.settings.setting', compact('config'));
    }

    /**
     * @param ProfileRequest $request
     * @return $this
     */
    public function profile(ProfileRequest $request)
    {
        $this->admin->updateProfile($request->all());
        return back()->with('ok', 'Change settings successfully');
    }
}
