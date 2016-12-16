<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends ApiController
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

    /**
     * Get posts for management.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function manage(Request $request)
    {
        $posts = $this->post->all($request->input('limit', 8), true);
        return response()->json($posts);
    }

    public function publish($id)
    {
        $result = $this->post->togglePublish($id);
        return $result ?
            response()->json([], REST_UPDATE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_TOGGLE_PUBLISH,
                'message' => trans('post.failed_publish')
            ], REST_BAD_REQUEST);
    }

    /**
     * Soft delete post.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->post->delete($id);
        return $result ?
            response()->json([], REST_DELETE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_DELETE_POST,
                'message' => trans('post.failed_delete')
            ], REST_BAD_REQUEST);
    }
}
