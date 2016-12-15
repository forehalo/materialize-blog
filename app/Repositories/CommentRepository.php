<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Parsedown;

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
        return Comment::where('post_id', $postID)
            ->with('parent')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Create.
     *
     * @param int $postID
     * @param array $inputs
     */
    public function create($postID, $inputs)
    {
        $parser = new Parsedown();
        $inputs['post_id'] = $postID;
        $inputs['content'] = $parser->parse($inputs['origin']);
        $comment = Comment::create($inputs);
        if ($comment->parent_id != 0) {
            $comment->load('parent');
        }

        // add on comment_count
        Post::where('id', $inputs['post_id'])->increment('comment_count');

        return $comment;
    }

    /**
     * Get unread comment count.
     *
     */
    public function getUnreadCommentCount()
    {
        return Comment::whereSeen(0)->count();
    }
}
