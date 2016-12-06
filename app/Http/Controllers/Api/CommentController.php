<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends ApiController
{
    /**
     * Comment repository.
     *
     * @var CommentRepository
     */
    protected $comment;

    /**
     * Constructor
     *
     * @param CommentRepository $comment [description]
     */
    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get comments belong to given post.
     *
     * @param $postID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByPost($postID)
    {
        $comments = $this->comment->getCommentsByPost($postID);

        return response()->json($comments);
    }

    /**
     * Create new comment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $postID)
    {
        $this->validate($request, [
            'parent_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email',
            'blog' => 'required|url',
            'origin' => 'required',
            'captcha' => 'required',
        ]);

        $inputs = $request->all();
        if ($inputs['captcha'] != session('captcha')) {
            return response()->json(['message' => trans('form_params_invalid'), 'errors' => ['captcha' => trans('wrong_captcha')]], 422);
        }

        $result = $this->comment->create($postID, $inputs);
        return response()->json($result);
    }
}
