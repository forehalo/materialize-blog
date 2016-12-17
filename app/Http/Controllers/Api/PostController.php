<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

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
            return response()->json(['error' => POST_NOT_FOUND, 'message' => trans('post.not_found')], REST_RESOURCE_NOT_FOUND);
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
        response()->json(['message' => trans('post.like_success')]) :
        response()->json(['error' => FAIL_TO_LIKE_POST, 'message' => trans('post.like_fail')], REST_BAD_REQUEST);
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
        response()->json(['message' => trans('post.publish_success')], REST_UPDATE_SUCCESS) :
        response()->json([
            'error'   => FAIL_TO_TOGGLE_PUBLISH,
            'message' => trans('post.publish_fail'),
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
        response()->json(['message' => trans('post.delete_success')], REST_DELETE_SUCCESS) :
        response()->json([
            'error'   => FAIL_TO_DELETE_POST,
            'message' => trans('post.delete_fail'),
        ], REST_BAD_REQUEST);
    }

    /**
     * Get origin data for editing.
     * 
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrigin($id)
    {
        $post = $this->post->origin($id);
        return !$post ? 
            response()->json(['error' => POST_NOT_FOUND, 'message' => trans('post.not_found')], REST_RESOURCE_NOT_FOUND) :
            response()->json($post);
    }

    public function store(Request $reqeust)
    {
        $this->validate($request, [
            'title' => 'required|string|between:1,255',
            'slug' => 'required|string|unique:posts,slug|between:1,255',
            'summary' => 'required',
            'origin' => 'required',
            'category' => 'required|string|between:1,16',
            'tags' => 'required|array',
            'published' => 'required|boolean'
        ]);
        $result = $this->post->store($request->all());
        return $result ? 
            response()->json([], REST_CREATE_SUCCESS) : 
            response()->json(['error' => FAIL_TO_CREATE_POST, 'message' => trans('post.create_fail')]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|between:1,255',
            'slug' => 'required|string|between:1,255',
            'summary' => 'required',
            'origin' => 'required',
            'category' => 'required|string|between:1,16',
            'tags' => 'required|array',
            'published' => 'required|boolean'
        ]);
        $result = $this->post->update($id, $request->all());
        return $result ? 
            response()->json([], REST_UPDATE_SUCCESS) : 
            response()->json(['error' => FAIL_TO_UPDATE_POST, 'message' => trans('post.update_fail')]);
    }
}
