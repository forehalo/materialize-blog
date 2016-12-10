<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    /**
     * PostRepository.
     *
     * @var PostRepository
     */
    protected $post;

    /**
     * PostController constructor.
     *
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * Get all posts.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $posts = $this->post->all($request->input('limit', 8));
        return response()->json($posts);
    }

    /**
     * Get post by slug.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBySlug($slug)
    {
        $post = $this->post->getByColumn('slug', $slug);
        if (is_null($post)) {
            return response()->json(['error' => POST_NOT_FOUND, 'message' => trans('post.not_found')], 404);
        } else {
            return response()->json($post);
        }
    }

    /**
     * Like the post.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like($id)
    {
        $result = $this->post->likePost($id);
        return $result ?
            response()->json(['message' => trans('post.success_like')]) :
            response()->json(['error' => FAIL_TO_LIKE_POST, 'message' => trans('post.failed_like')], 400);
    }
}
