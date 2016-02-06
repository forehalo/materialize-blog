<?php namespace App\Repositories;

use App\Models\Post;

/**
 * Class BlogRepository.php
 * @package
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class PostRepository
{
    protected $model;


    /**
     * BlogRepository constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    /**
     * Get all posts.
     *
     * @param int $n pagination
     * @param bool $published whether fetch unpublished posts.
     * @return mixed
     */
    public function all($n = null, $published = true)
    {
        $posts = $this->model
                    ->select('id', 'title', 'summary', 'comment_count', 'view_count', 'favorite_count', 'created_at', 'slug', 'published')
                    ->orderBy('created_at', 'desc');

        if ($published) {
            $posts = $posts->wherePublished(true);
        }

        return $n ? $posts->paginate($n) : $posts->get();
    }

    /**
     * Get post body.
     *
     * @param $id
     * @return mixed
     */
    public function body($id)
    {
        return $this->getByColumn($id)->body;
    }

    /**
     * Get post by given column.
     *
     * @param string $value column value.
     * @param string $column column name, default={id}
     * @return
     */
    public function getByColumn($value, $column = 'id')
    {
        $post = $this->model->where($column, $value)->first();

        $post->view_count++;
        $post->update();
        return $post;
    }

    /**
     * Update favorite count
     *
     * @param $id
     */
    public function doFavorite($id)
    {
        $post = $this->getByColumn($id);

        $post->favorite_count++;

        $post->save();
    }

    /**
     * Update post published status
     *
     * @param $input
     * @param $id
     */
    public function updatePublish($input, $id)
    {
        $post = $this->getByColumn($id);

        $post->published = $input['published'] == 'true';

        $post->save();
    }


}