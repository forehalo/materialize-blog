<?php

use App\Models\Admin, App\Models\Category, App\Models\Comment, App\Models\Link, App\Models\Post, App\Models\PostTag, App\Models\Tag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(PostTagTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(LinkTableSeeder::class);
    }
}

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'authentication' => bcrypt('admin'),
            'desc' => '说一句话来介绍一下自己吧',
            'status' => 0,
            'remember_token' => str_random(10)
        ]);
    }
}

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Cate 0',
            'hot' => 1
        ]);
        Category::create([
            'name' => 'Cate 1',
            'hot' => 2
        ]);
        Category::create([
            'name' => 'Cate 2',
            'hot' => 3
        ]);
        Category::create([
            'name' => 'Cate 3',
            'hot' => 4
        ]);
        Category::create([
            'name' => 'Cate 4',
            'hot' => 5
        ]);
    }
}

class TagTableSeeder extends Seeder
{
    public function run()
    {
        Tag::create([
            'name' => 'Tag 0',
            'hot' => 15
        ]);
        Tag::create([
            'name' => 'Tag 1',
            'hot' => 63
        ]);
        Tag::create([
            'name' => 'Tag 2',
            'hot' => 23
        ]);
        Tag::create([
            'name' => 'Tag 3',
            'hot' => 36
        ]);
        Tag::create([
            'name' => 'Tag 4',
            'hot' => 73
        ]);
    }
}

class PostTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        Post::create([
            'title' => $faker->sentence(),
            'summary' => $faker->paragraph(),
            'category_id' => 1,
            'body' => $faker->text(),
            'origin' => '',
            'comment_count' => 1,
            'view_count' => 10,
            'favorite_count' => 5,
            'published' => 1,
        ]);
        Post::create([
            'title' => $faker->sentence,
            'summary' => $faker->paragraph,
            'category_id' => 2,
            'body' => $faker->text(),
            'origin' => '',
            'comment_count' => 2,
            'view_count' => 11,
            'favorite_count' => 6,
            'published' => 1,
        ]);
        Post::create([
            'title' => $faker->sentence,
            'summary' => $faker->paragraph,
            'category_id' => 3,
            'body' => $faker->text(),
            'origin' => '',
            'comment_count' => 2,
            'view_count' => 12,
            'favorite_count' => 4,
            'published' => 1,
        ]);
        Post::create([
            'title' => $faker->sentence,
            'summary' => $faker->paragraph,
            'category_id' => 4,
            'body' => $faker->text(),
            'origin' => '',
            'comment_count' => 1,
            'view_count' => 16,
            'favorite_count' => 5,
            'published' => 0,
        ]);
    }
}

class PostTagTableSeeder extends Seeder
{
    public function run()
    {
        PostTag::create([
            'post_id' => 1,
            'tag_id' => 1
        ]);
        PostTag::create([
            'post_id' => 1,
            'tag_id' => 2
        ]);
        PostTag::create([
            'post_id' => 1,
            'tag_id' => 3
        ]);
        PostTag::create([
            'post_id' => 2,
            'tag_id' => 1
        ]);
        PostTag::create([
            'post_id' => 2,
            'tag_id' => 3
        ]);
        PostTag::create([
            'post_id' => 2,
            'tag_id' => 4
        ]);
        PostTag::create([
            'post_id' => 3,
            'tag_id' => 1
        ]);
        PostTag::create([
            'post_id' => 3,
            'tag_id' => 5
        ]);
        PostTag::create([
            'post_id' => 4,
            'tag_id' => 1
        ]);
        PostTag::create([
            'post_id' => 4,
            'tag_id' => 3
        ]);
        PostTag::create([
            'post_id' => 4,
            'tag_id' => 5
        ]);
    }
}

class CommentTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        Comment::create([
            'post_id' => 1,
            'parent_id' => 0,
            'name' => $faker->name,
            'email' => $faker->email,
            'blog' => $faker->url,
            'content' => $faker->paragraph
        ]);
        Comment::create([
            'post_id' => 2,
            'parent_id' => 0,
            'name' => $faker->name,
            'email' => $faker->email,
            'blog' => $faker->url,
            'content' => $faker->paragraph
        ]);
        Comment::create([
            'post_id' => 2,
            'parent_id' => 2,
            'name' => $faker->name,
            'email' => $faker->email,
            'blog' => $faker->url,
            'content' => $faker->paragraph
        ]);
        Comment::create([
            'post_id' => 3,
            'parent_id' => 0,
            'name' => $faker->name,
            'email' => $faker->email,
            'blog' => $faker->url,
            'content' => $faker->paragraph
        ]);
        Comment::create([
            'post_id' => 3,
            'parent_id' => 0,
            'name' => $faker->name,
            'email' => $faker->email,
            'blog' => $faker->url,
            'content' => $faker->paragraph
        ]);
        Comment::create([
            'post_id' => 4,
            'parent_id' => 0,
            'name' => $faker->name,
            'email' => $faker->email,
            'blog' => $faker->url,
            'content' => $faker->paragraph
        ]);
    }
}


class LinkTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
        Link::create([
            'name' => $faker->name,
            'link' => $faker->url
        ]);
    }
}