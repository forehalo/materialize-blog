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
     * @return Comment
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

    /**
     * Get all comment.
     *
     * @param int $limit
     * @return mixed
     */
    public function all($limit = 8)
    {
        return Comment::with(['post' => function ($query) {
            $query->select('id', 'slug', 'title');
        }])->orderBy('created_at', 'desc')->paginate($limit);
    }

    /**
     * Toggle boolean column
     *
     * @param $id
     * @param $column
     * @return boolean
     */
    public function toggle($id, $column)
    {
        $comment = Comment::where('id', $id)->first();
        return $comment->update([$column => ! $comment->{$column}]);
    }

    /**
     * Destroy comment.
     *
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        return Comment::destroy($id);
    }
}
