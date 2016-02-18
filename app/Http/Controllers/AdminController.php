<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequests\AuthRequest;
use App\Http\Requests\SettingRequests\LinkRequest;
use App\Http\Requests\SettingRequests\ProfileRequest;
use App\Http\Requests\SettingRequests\ViewRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Repositories\AdminRepository;
use Illuminate\Contracts\Auth\Guard;
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
     * Update profile.
     *
     * @param ProfileRequest $request
     * @return $this
     */
    public function profile(ProfileRequest $request)
    {
        $this->admin->update($request->all());
        return redirect('/settings#profile')->with('ok', 'Update profile settings successfully');
    }

    /**
     * Update view settings.
     *
     * @param ViewRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function view(ViewRequest $request)
    {
        $this->admin->update($request->all());

        return redirect('/settings#view')->with('ok', 'Update view settings successfully');
    }

    /**
     * Update link settings.
     *
     * @param LinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function link(LinkRequest $request)
    {
        $this->admin->update($request->all());

        return redirect('/settings#link')->with('ok', 'Update link settings successfully');
    }

    /**
     * Update friend links.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function friend(Request $request)
    {
        $this->admin->updateFriend($request->all());

        if ($request->ajax()) {
            return response()->json();
        } else {
            return redirect('/settings#link')->with('ok', 'Add friend link successfully');
        }
    }

    public function auth(AuthRequest $request, Guard $auth)
    {
        $this->admin->authReset($request->all(), $auth);

        return redirect('/dashboard')->with('ok', 'Change Auth successfully');

    }
}
