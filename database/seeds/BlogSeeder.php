<?php

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create categories
        factory(App\Models\Category::class, 6)->create()->each(function ($category) {
            // create posts and save relations
            $category->posts()->saveMany(
                factory(App\Models\Post::class, 5)->create()->each(function ($post) {
                    // create comment
                    $post->comments()->saveMany(
                        factory(App\Models\Comment::class, 2)->create()
                    );
                    // create tags
                    $post->tags()->sync(
                        factory(App\Models\Tag::class, 2)->create()->pluck('id')->toArray()
                    );
                })
            );
        });

        // friend links
        factory(App\Models\Link::class, 5)->create();
    }
}
