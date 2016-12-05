<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    /**
     * Get comments of posts.
     *
     * @param $postID
     * @return mixed
     */
    public function getCommentsByPost($postID)
    {
        return Comment::where('post_id', $postID)->orderBy('created_at', 'desc')->get();
    }

}
