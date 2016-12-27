<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendMailNotification;
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
     * @param $postID
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
        ]);

        $inputs = $request->all();
        
        $result = $this->comment->create($postID, $inputs);
        dispatch(new SendMailNotification($result));
        return response()->json($result);
    }

    /**
     * Get all comments for dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function manage(Request $request)
    {
        $comments = $this->comment->all($request->input('limit', 8));
        return $comments;
    }

    /**
     * Toggle comment valid status.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function valid($id)
    {
        $result = $this->comment->toggle($id, 'valid');
        return $result ?
            response()->json([], REST_UPDATE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_TOGGLE_VALID,
                'message' => trans('comment.toggle_valid_fail'),
            ], REST_BAD_REQUEST);
    }

    /**
     * Toggle comment seen status.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function seen($id)
    {
        $result = $this->comment->toggle($id, 'seen');
        return $result ?
            response()->json([], REST_UPDATE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_TOGGLE_SEEN,
                'message' => trans('comment.toggle_seen_fail'),
            ], REST_BAD_REQUEST);
    }

    /**
     * Destroy comment.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->comment->destroy($id);
        return $result ?
            response()->json([], REST_DELETE_SUCCESS) :
            response()->json([
                'error' => FAIL_TO_DELETE_COMMENT,
                'message' => trans('comment.delete_fail'),
            ], REST_BAD_REQUEST);
    }

    /**
     * Unsubscribe comment reply notification
     *
     * @param Request $request
     * @return string
     */
    public function unsubscribe(Request $request)
    {
        $token = $request->input('c');
        if (!$token) {
            return 'Invalid token';
        }

        $pair = explode('-', base64_decode($token));
        return $this->comment->unsubscribe($pair) ?
            trans('unsubscribe_success') :
            trans('unsubscribe_fail');
    }
}
