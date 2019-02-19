<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
      'category_id' => $faker->numberBetween($min = 1, $max = 4),
      'subcategory_id' => $faker->numberBetween($min = 1, $max = 1),
      'uid' => uniqid('p_'),
      'name' => $faker->company,
      'price' => $faker->numberBetween($min = 500, $max = 10000),
      'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
      'thumbnail' => 'p_thumb_5bfd0520ac61a.jpg',
      'visibility' => 'public',
    ];
});
