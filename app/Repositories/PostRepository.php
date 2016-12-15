<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{

    /**
     * Get all posts order by publish date.
     *
     * @param int $limit
     * @param boolean $manage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($limit = 8, $manage = false)
    {
        $prepare = Post::orderBy('created_at', 'desc');

        if ($manage) {
            $prepare->manage();
        } else {
            $prepare->show()->with('tags');
        }

        return $prepare->paginate((int)$limit)->toArray();
    }

    /**
     * Get record(s) by given column.
     *
     * @param  string $column
     * @param  mixed $value
     * @param  boolean $collected
     * @return Illuminate\Support\Collection|App\Models\Post
     */
    public function getByColumn($column, $value, $collected = false)
    {
        $prepare = Post::where($column, $value);
        return $collected ? $prepare->get() : $prepare->with(['tags', 'category'])->first();
    }


    /**
     * Like the post.
     *
     * @param int $postID
     */
    public function likePost($postID)
    {
        return Post::where('id', $postID)->increment('favorite_count');
    }

    /**
     * Group all dates with posts published, group by year/month.
     *
     * @return array
     */
    public function groupDates()
    {
        $dates = Post::select('created_at')->where('published', true)->orderBy('created_at', 'desc')->get()->pluck('created_at');

        $group = [];
        foreach ($dates as $date) {
            $year = $date->year;
            $month = $date->month;
            if (! array_key_exists($date->year, $group)) {
                $group[$year] = ['year' => $year, 'months' => []];
            }

            if (array_search($month, $group[$year]['months']) === false) {
                array_push($group[$year]['months'], $month);
            }
        }
        return array_values($group);
    }

    /**
     * Get articles posted in year-month.
     *
     * @param string $yearMonth
     */
    public function getPostsByYearMonth($yearMonth)
    {
        $date = explode('-', $yearMonth);
        $from = Carbon::create($date[0], $date[1], 1, 0, 0, 0);
        $to = Carbon::create($date[0], (int)$date[1] + 1, 0, 23, 59, 59);
        return Post::select('id', 'title', 'slug')->whereBetween('created_at', [$from, $to])->get();
    }

    /**
     * Get post count.
     *
     */
    public function getPostCount()
    {
        return Post::count();
    }
}
