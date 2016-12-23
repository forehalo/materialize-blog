<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// Category
$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'hot' => $faker->randomDigitNotNull,
    ];
});

// Tag
$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'hot' => $faker->randomDigitNotNull,
    ];
});

// Post
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $body = $faker->paragraphs(4, true);
    return [
        'title' => $faker->sentence(),
        'slug' => $faker->slug,
        'summary' => $faker->sentence(20),
        'body' => "<p>$body</p>",
        'origin' => $body,
        'comment_count' => 2,
        'view_count' => $faker->randomDigitNotNull,
        'favorite_count' => $faker->randomDigitNotNull,
        'published' => $faker->boolean,
        'category_id' => 0,
    ];
});

// Comment
$factory->define(App\Models\Comment::class, function (Faker\Generator $faker) {
    $body = $faker->sentence();
    return [
        'parent_id' => 0,
        'name' => $faker->name,
        'email' => $faker->email,
        'blog' => $faker->url,
        'origin' => $body,
        'content' => "<p>$body</p>",
        'seen' => $faker->boolean,
        'valid' => $faker->boolean,
        'post_id' => 0,
    ];
});

// Link
$factory->define(App\Models\Link::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'link' => $faker->url,
    ];
});
