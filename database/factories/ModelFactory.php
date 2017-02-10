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

$factory->define(\Editora\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\Editora\Models\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => ucfirst($faker->unique()->word)
    ];
});

$factory->define(\Editora\Models\Book::class, function (Faker\Generator $faker) {

    $repository = app(\Editora\Repositories\UserRepository::class);
    /** @var \Illuminate\Database\Eloquent\Collection $user */
    $authorId = $repository->all()->random()->id;

    return [
        'title' => $faker->sentence(2),
        'subtitle' => $faker->sentence(3),
        'price' => $faker->randomFloat(2,10,100),
        'author_id' => $authorId  ///numberBetween(10, 50)
    ];
});