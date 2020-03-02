<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Family;
use App\Group;
use App\Product;
use App\Task;
use App\User;
use App\UserProfile;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Group::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
    ];
});

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'group_id' => rand(1,2),
    ];
});

$factory->define(Task::class, function (Faker $faker){
    $status = Task::TASK_STATUS;
    $status = $status[rand(0, 1)];

    return [
        'group_id' => rand(0,2),
        'user_id' => rand(1,10),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'expire_date' =>$faker->creditCardExpirationDate,
        'cost' => rand(100, 500),
        'status' => $status,
        'is_done' => rand(true, false),
];
});

$factory->define(Category::class, function (Faker $faker) {

    return [
        'name' => $faker->domainName,
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    $category_id = rand(1, 10);
    $type = Product::PRODUCT_TYPES;
    $type = $type[rand(0, 2)];
    $price = rand(100, 500);

    return [
        'category_id' => $category_id,
        'type' => $type,
        'details' => $faker->sentence,
        'price' => $price,
    ];
});

