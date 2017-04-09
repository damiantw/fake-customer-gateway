<?php

require __DIR__ . '/../vendor/fzaninotto/faker/src/autoload.php';

$faker = Faker\Factory::create();
$customers = [];

//Generate some fake data
for ($i = 0; $i < 50; ++$i) {
    $customers[] = [
        'id' => $i + 1,
        'name' => $faker->name,
        'company' => $faker->company,
        'email' => $faker->safeEmail,
        'phone_number' => $faker->phoneNumber,
    ];
}



//Save it to disk
$jsonFileNumber = 1;
while(file_exists($filename = __DIR__ . '/../data/customer-data-' . $jsonFileNumber . '.json')) {
    $jsonFileNumber++;
}

file_put_contents($filename, json_encode($customers, JSON_PRETTY_PRINT));