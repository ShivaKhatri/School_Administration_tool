<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
$factory->define(App\Model\Section::class, function (Faker $faker) {

    return [
        'name'=>$faker->sentence(7),
        'description'=>$faker->realText(rand(100,700)),
        'created_at'=>Carbon::now('Asia/kathmandu'),
        'updated_at'=>Carbon::now('Asia/kathmandu'),
    ];
});
