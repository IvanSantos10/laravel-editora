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

$factory->define(\Editora\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Editora\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => ucfirst($faker->unique()->word)
    ];
});

$factory->define(\Editora\Book::class, function (Faker\Generator $faker) {

    return [
        'title' => ucfirst($faker->unique()->word),
        'subtitle' => ucfirst($faker->word),
        'price' => $faker->randomFloat(2,2,2),
        'user_id' => 1 ///numberBetween(10, 50)
    ];
});