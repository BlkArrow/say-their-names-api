<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DonationLinks;
use Faker\Generator as Faker;

$factory->define(DonationLinks::class, function (Faker $faker) {
    return [
        'title' => 'Lorem Ipsum Fund',
        'description' => $faker->paragraph,
        'link' => $faker->url,
        'status' => 1,
    ];
});
