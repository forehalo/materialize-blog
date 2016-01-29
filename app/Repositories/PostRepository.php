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
     * Get posts collection for font index.
     *
     * @param int $n pagination
     * @return mixed
     */
    public function indexFront($n = 5)
    {
        $posts = $this->model->select('id', 'title', 'summary', 'comment_count', 'view_count', 'favorite_count', 'created_at')
                            ->wherePublished(true)
                            ->orderBy('created_at', 'desc');
        return $posts->paginate($n);
    }

    public function body($id)
    {
        return $this->getById($id)->body;
    }

    private function getById($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all(['title', 'slug', 'created_at']);
    }
}