<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
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

$factory->define(Project::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
    ];
});

$factory->define(User::class, function (Faker $faker) {
    $projects = Project::all()->pluck('id');

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'hr_wage' => rand(10, 50),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'project_id' => rand(1, 3),
    ];
});

$factory->define(UserProfile::class, function (Faker $faker) {

    return [
        'user_id' => $faker->name,
        'phone' => $faker->phoneNumber,
        'birth_date' => $faker->dateTimeThisCentury(),
    ];
});

$factory->define(Task::class, function (Faker $faker){
    $status = Task::TASK_STATUS;
    $status = $status[rand(1, 2)];
    $projects = Project::all()->pluck('id');
    $users = User::all()->pluck('id');

    return [
        'project_id' => rand($projects->first(), $projects->last()),
        'user_id' => rand($users->first(), $users->last()),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'expire_date' =>$faker->creditCardExpirationDate,
        'time_spent' => $faker->time('H:i'),
        'task_cost' => rand(100, 500),
        'status' => $status,
        'is_done' => rand(true, false),
];
});