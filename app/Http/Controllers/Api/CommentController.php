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

    public function getByPost($postID)
    {
        $comments = $this->comment->getCommentsByPost($postID);

        return response()->json($comments);
    }
}
