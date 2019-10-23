<?php

use Faker\Generator as Faker;

$factory->define(App\Notification::class, function(Faker $faker) {
	return [
		'title' => $faker->sentence(6),
		'body'  => $faker->sentence(12),
	];
});
