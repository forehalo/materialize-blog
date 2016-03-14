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

        // Update post view count, tags hot, category hot
        if (!is_null($post)) {
            $post->view_count++;
            $post->update();

            // tags
            $tags = $post->tags;
            foreach($tags as $tag){
                $tag->hot++;
                $tag->update();
            }

            $category = $post->category;
            $category->hot++;
            $category->update();

            return $post;
        } else {
            return null;
        }
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

        $post->published = $input['publish'] == 'true';

        $post->update();
    }


    /**
     * Destroy a post.
     *
     * @param $id
     */
    public function destroy($id)
    {
        $post = $this->model->find($id);

        $post->tags()->detach();

        $post->delete();
    }

    /**
     * Store new post in database.
     *
     * @param $inputs
     */
    public function store($inputs)
    {
        $post = new $this->model();

        $this->savePost($post, $inputs);
    }

    /**
     * Update a post.
     *
     * @param $inputs
     * @param $id post id
     */
    public function update($inputs, $id)
    {
        $post = $this->getByColumn($id);

        $this->savePost($post, $inputs);
    }

    /**
     * Parse Markdown.
     *
     * @param $origin
     * @return string HTML content
     */
    public function parseOrigin($origin)
    {
        $parse = new Parsedown();
        return $parse->text($origin);
    }

    /**
     * Get or create new category and return category id.
     *
     * @param $name category name
     * @return mixed category id
     */
    public function parseCategory($name)
    {

        $category = $this->category->whereName($name)->first();

        if (is_null($category)) {
            $category = new $this->category();
            $category->name = $name;
            $category->save();
        }

        return $category->id;
    }

    /**
     * Synchronize post tags relation.
     *
     * @param $post
     * @param string $tags
     */
    private function syncTags($post, $tags)
    {

        $tags_id = [];
        $tags = explode(',', $tags);

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

    /**
     * Store post information in database.
     *
     * @param $post
     * @param $inputs
     */
    private function savePost($post, $inputs)
    {
        $post->title = $inputs['title'];
        $post->slug = $inputs['slug'];
        $post->summary = $inputs['summary'];
        $post->origin = $inputs['origin'];
        $post->body = $this->parseOrigin($inputs['origin']);
        $post->published = isset($inputs['publish']);
        $post->category_id = $this->parseCategory($inputs['category']);

        $post->save();

        $this->syncTags($post, $inputs['tags']);
    }

    /**
     * Search in all published posts.
     *
     * @param $key
     * @param int $pagination
     * @return mixed
     */
    public function search($key, $pagination = 10)
    {
        return $this->model->where('title', 'like', "%{$key}%")
                    ->orWhere('body', 'like', "%{$key}%")
                    ->wherePublished(true)
                    ->paginate($pagination);
    }


}