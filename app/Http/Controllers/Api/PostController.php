<?php

namespace App\Http\Controllers\Api;

use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Setting;

class PostController extends ApiController
{
    /**
     * PostRepository.
     *
     * @var PostRepository
     */
    protected $post;

    /**
     * Path of stored posts' markdown files.
     *
     * @var string
     */
    protected $relativePath;

    /**
     * PostController constructor.
     *
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
        $this->relativePath = 'posts/';
    }

    /**
     * Get all posts.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $posts = $this->post->all($request->input('limit', Setting::get('post_per_page')));
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
            response()->json([], REST_CREATE_SUCCESS) :
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
        $posts = $this->post->all($request->input('limit', Setting::get('dashboard_post_per_page')), true);
        return response()->json($posts);
    }

    public function publish($id)
    {
        $result = $this->post->togglePublish($id);
        return $result ?
            response()->json([], REST_UPDATE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_TOGGLE_PUBLISH,
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
            response()->json([], REST_DELETE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_DELETE_POST,
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
        return ! $post ?
            response()->json(['error' => POST_NOT_FOUND, 'message' => trans('post.not_found')], REST_RESOURCE_NOT_FOUND) :
            response()->json($post);
    }

    /**
     * Store a new post.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
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
            response()->json($result, REST_CREATE_SUCCESS) :
            response()->json(['error' => FAIL_TO_CREATE_POST, 'message' => trans('post.create_fail')]);
    }

    /**
     * Update an existing post.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Export post to local disk and return download response.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($id)
    {
        $post = $this->post->origin($id);
        $fullPath = $this->saveAsMarkdown($post);
        return response()->download($fullPath, $post['slug'].'.md');
    }

    /**
     * Store post in markdown file.
     *
     * @param array $post
     * @return string
     */
    private function saveAsMarkdown(array $post)
    {
        $lastExportTime = $post['exported_at'];
        $lastUpdateTime = Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $post['updated_at'])->timestamp;
        $filename = "$this->relativePath{$post['slug']}-$lastExportTime.md";

        if (! $lastExportTime || $lastExportTime < $lastUpdateTime || ! Storage::exists($filename)) {
            $now = time();
            $filename = "$this->relativePath{$post['slug']}-$now.md";
            $content = $this->generateMarkdownContent($post);
            Storage::put($filename, $content);
            $this->post->updateExportedAt($post['id'], $now);
        }

        return storage_path('app/'.$filename);
    }

    /**
     * Post to markdown format.
     *
     * @param array $post
     * @return string
     */
    private function generateMarkdownContent(array $post)
    {
        $tags = implode("/", $post['tags']);
        $content = <<<Content
---
title: {$post['title']}
slug: {$post['slug']}
summary: {$post['summary']}
category: {$post['category']}
tags: {$tags}
---
{$post['origin']}
Content;
        return $content;
    }
}
