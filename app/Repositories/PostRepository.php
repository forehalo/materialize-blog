<?php namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Parsedown;

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
    /**
     * Post Model
     */
    protected $model;

    /**
     * Category Model
     */
    protected $category;

    /**
     * Tag Model
     */
    protected $tag;

    /**
     * BlogRepository constructor.
     * @param Post $post
     * @param Category $category
     * @param Tag $tag
     */
    public function __construct(Post $post, Category $category, Tag $tag)
    {
        $this->model = $post;
        $this->category = $category;
        $this->tag = $tag;
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
        $post = $this->model->find($id);

        $post->favorite_count++;

        $post->update();
    }

    /**
     * Update post published status
     *
     * @param $input
     * @param $id
     */
    public function updatePublish($input, $id)
    {
        $post = $this->model->find($id);

        $post->published = $input['published'] == 'true';

        $post->update();
    }


    /**
     * Destroy a post.
     *
     *
     * @param $id
     */
    public function destroy($id)
    {
        $post = $this->model->find($id);

        $post->tags()->detach();

        $post->delete();
    }

    public function store($inputs)
    {
        $post = new $this->model();

        $post->title = $inputs['title'];
        $post->slug = $inputs['slug'];
        $post->summary = $inputs['summary'];
        $post->origin = $inputs['origin'];
        $post->body = $this->parseOrigin($inputs['origin']);
        $post->published = isset($inputs['publish']);

        $category = $this->category->whereName($inputs['category'])->first();

        if ($category == null) {
            $category = new $this->category();
            $category->name = $inputs['category'];
            $category->save();
        }
        $post->category_id = $category->id;
        $post->save();

        $tags_id = [];
        $tags = explode(',', $inputs['tags']);

        foreach ($tags as $tag) {
            $tag_ref = $this->tag->whereName($tag)->first();
            if (is_null($tag_ref)) {
                $tag_ref = new $this->tag();
                $tag_ref->name = $tag;
                $tag_ref->save();
            }
            array_push($tags_id, $tag_ref->id);
        }

        $post->tags()->sync($tags_id);

    }

    public function parseOrigin($origin)
    {
        $parse = new Parsedown();
        return $parse->text($origin);
    }

    public function parseCategory()
    {

    }


}