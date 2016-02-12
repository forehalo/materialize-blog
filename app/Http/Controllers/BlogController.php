<?php

namespace App\Http\Controllers;

/**
 * Class BlogController.php
 * @package     App\Http\Controllers
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * BlogRepository object.
     *
     * @var PostRepository $blog
     */
    protected $blog;

    /**
     * CommentRepository object.
     *
     * @var CommentRepository $comment
     */
    protected $comment;

    /**
     * BlogController constructor.
     *
     * @param PostRepository $blog
     * @param CommentRepository $comment
     */
    public function __construct(PostRepository $blog, CommentRepository $comment)
    {
        $this->blog = $blog;
        $this->comment = $comment;

        $this->middleware('auth', ['only' => ['create', 'store', 'update', 'edit', 'destroy']]);
    }

    /**
     * Display posts list order by created_at
     * This controller return posts shown in collapsible view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function frontIndex()
    {
        return view('front.posts.index', $this->index());
    }

    /**
     * Unlike 'frontIndex', this action used to show normal list of posts
     * and post clicked will be shown in a single page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function normalIndex()
    {
        return view('front.posts.normalIndex', $this->index());
    }

    /**
     * For back-end posts index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backIndex()
    {
        $posts = $this->blog->all(10, false);
        $links = $posts->links();

        return view('back.blog.index', compact('posts', 'links'));
    }

    /**
     * Get all posts and make pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->blog->all(config('blog.pagination'));
        $links = $posts->links();

        return compact('posts', 'links');
    }


    /**
     * Get post body through ajax or redirect to 404.
     *
     * @param Request $request
     * @param string $id format: post-{id}
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function body(Request $request, $id)
    {
        if ($request->ajax()) {
            return response()->json(['body' => $this->blog->body($id)]);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Get comments belong to post gotten by {id}
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Request $request, $id)
    {
        $post = $this->blog->getByColumn($id);
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return response()->json($comments);
        } else {
            return view('errors.404');
        }
    }

    public function favorite(Request $request, $id)
    {
        $this->blog->doFavorite($id);

        if ($request->ajax()) {
            return response()->json();
        } else {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.blog.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->blog->store($request->all());

        return redirect('admin/posts')->with('ok', 'Create post successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug post url slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = $this->blog->getByColumn($slug, 'slug');

        return view('front.posts.post', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->blog->getByColumn($id);
        $post->category = $post->category->name;
        $tags = [];

        foreach ($post->tags as $tag) {
            array_push($tags, $tag->name);
        }
        $post->tags = implode(',', $tags);

        return view('back.blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->blog->update($request->all(), $id);

        return redirect('admin/posts')->with('ok', 'Update post successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blog->destroy($id);

        return redirect('admin/posts')->with('ok', 'Delete post successfully.');
    }

    /**
     * Toggle post published status.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(Request $request, $id)
    {
        $this->blog->updatePublish($request->all(), $id);

        return response()->json();
    }
}
