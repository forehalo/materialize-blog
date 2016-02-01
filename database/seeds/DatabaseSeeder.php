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
            'name' => 'Cate0',
            'hot' => rand(0, 300)
        ]);
        Category::create([
            'name' => 'Cate1',
            'hot' => rand(0, 300)
        ]);
        Category::create([
            'name' => 'Cate2',
            'hot' => rand(0, 300)
        ]);
        Category::create([
            'name' => 'Cate3',
            'hot' => rand(0, 300)
        ]);
        Category::create([
            'name' => 'Cate4',
            'hot' => rand(0, 300)
        ]);
    }
}

class TagTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            Tag::create([
                'name' => 'Tag' . $i,
                'hot' => rand(0, 300)
            ]);
        }
    }
}

class PostTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $cates = Category::lists('id')->toArray();
        for ($i = 1; $i <= 50; $i++) {
            Post::create([
                'title' => $faker->sentence(),
                'summary' => $faker->paragraph(),
                'category_id' => $faker->randomElement($cates),
                'body' => $faker->text(10000),
                'origin' => '',
                'comment_count' => rand(0, 10),
                'view_count' => rand(0, 200),
                'favorite_count' => rand(0, 100),
                'published' => rand(0, 1),
                'slug' => 'post-' . $i,
            ]);
        }
    }
}

class PostTagTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $tags = Tag::lists('id')->toArray();
        for ($i = 1; $i <= 50; $i++) {
            PostTag::create([
                'post_id' => $i,
                'tag_id' => $faker->randomElement($tags)
            ]);
            PostTag::create([
                'post_id' => $i,
                'tag_id' => $faker->randomElement($tags)
            ]);
            PostTag::create([
                'post_id' => $i,
                'tag_id' => $faker->randomElement($tags)
            ]);
        }
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
            'name' => 'username',
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
            'post_id' => 1,
            'parent_id' => 1,
            'parent_name' => 'username',
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