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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'slug' => uniqid (mt_rand(), true),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $name = $faker->colorName;
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'description' => $faker->paragraph(1, true),
    ];
});


$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'intro' => $faker->paragraph,
        'fulltext' => $faker->paragraph(5, true)
                      . '<h3>' . $faker->sentence() . '</h3>'
                      . $faker->paragraph(5, true)
                      . '<h3>' . $faker->sentence() . '</h3>'
                      . $faker->paragraph(3, true),
        'publish' => '1',
    ];
});
