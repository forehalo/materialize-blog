<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function getCommentsByPost($postID)
    {
        return Comment::where('post_id', $postID)->orderBy('created_at', 'desc')->get();
    }

}
