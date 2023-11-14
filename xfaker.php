<?php

require 'vendor/autoload.php'; // Include the Faker library

use Faker\Factory;

$faker = Factory::create(); // Create a Faker generator

$objects = [];

for ($i = 1; $i <= 100; $i++) {
    $objects[] = [
        'parentAmount' => $faker->numberBetween(100, 1000),
        'Currency' => $faker->randomElement(['USD', 'EUR', 'GBP', 'CAD', 'AUD']),
        'parentEmail' => "parent{$i}@example.com",
        'statusCode' => $faker->numberBetween(1, 3),
        'registerationDate' => $faker->date('Y-m-d'),
        'parentIdentification' => $faker->uuid,
    ];
}

$jsonContent = json_encode($objects, JSON_PRETTY_PRINT);

file_put_contents('providers/xdata'.rand(1111,9999).'.json', $jsonContent);


echo "JSON file generated successfully!\n";
