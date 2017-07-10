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
    $startDateTime = $faker->dateTime;
    $day = $faker->numberBetween(0, 5);
    $hour = $faker->numberBetween(0, 23);
    $interval_spec = "P{$day}DT{$hour}H";

    return [
        'title'          => $faker->sentence,
        'body'           => $faker->paragraph(3),
        'vacancies'      => $faker->numberBetween(1, 20),
        'start_datetime' => $startDateTime,
        'end_datetime'   => $startDateTime->add(new DateInterval($interval_spec)),
    ];
});
$factory->define(App\Permission::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->words,
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
$factory->define(App\Menu::class, function (Faker\Generator $faker) {

    $collection = null;

    return [
        'title'         => $faker->word,
        'url'           => $faker->uuid,
        'has_menu_type' => function () use ($collection) {
            $collection = factory(\App\Collection::class)->create();

            return get_class($collection);
        },
        'has_menu_id'   => function () use ($collection) {
            return $collection->id;
        },
        'is_active'     => true,
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