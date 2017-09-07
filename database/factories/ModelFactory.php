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

use Anacreation\MultiAuth\Model\Admin;
use Anacreation\MultiAuth\Model\AdminPermission;
use Anacreation\MultiAuth\Model\AdminRole;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'employee_id'    => $faker->uuid,
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Event::class, function (Faker\Generator $faker) {
    $now = \Carbon\Carbon::now();
    $getRandomDays = function () {
        return rand(1, 10);
    };

    return [
        'title'          => $faker->sentence,
        'body'           => $faker->paragraph(3),
        'vacancies'      => $faker->numberBetween(1, 20),
        'start_datetime' => $now->addDays($getRandomDays()),
        'end_datetime'   => $now->addDays($getRandomDays())
    ];
});
$factory->define(App\Permission::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->word,
        'code'  => $faker->uuid
    ];
});
$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->word,
        'code'  => $faker->uuid
    ];
});
$factory->define(App\Lesson::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->sentence,
        'body'          => $faker->paragraph(3),
        'permission_id' => 1
    ];
});
$factory->define(App\Collection::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->sentence,
        'permission_id' => function () {
            return factory(App\Permission::class)->create()->id;
        }
    ];
});
$factory->define(App\Test::class, function (Faker\Generator $faker) {
    return [
        'title'           => $faker->sentence,
        'question_number' => 2
    ];
});
$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->sentence,
        'keywords' => implode(",", $faker->words(5)),
        'content'  => $faker->paragraph()
    ];
});
$factory->define(\App\LessonSchedule::class, function (Faker\Generator $faker) {
    return [
        'compare' => "user",
        'days'    => 10,
    ];
});

$factory->define(Admin::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(AdminPermission::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->name,
        'code'  => $faker->unique()->word,
    ];
});
$factory->define(AdminRole::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->name,
        'code'  => $faker->unique()->word,
    ];
});