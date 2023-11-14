<?php

require 'vendor/autoload.php';

$faker = Faker\Factory::create();

$data = [];

for ($i = 0; $i < 100; $i++) {
    $data[] = [
        'balance' => $faker->randomNumber(3),
        'currency' => $faker->currencyCode,
        'email' => $faker->email,
        'status' => $faker->numberBetween(1, 100),
        'created_at' => $faker->date('Y-m-d'),
        'id' => $faker->uuid,
    ];
}

file_put_contents('providers/ydata'.rand(1111,9999).'.json', json_encode($data, JSON_PRETTY_PRINT));

?>
