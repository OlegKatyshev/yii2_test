<?php

use Faker\Factory;

$faker = Factory::create();
$data = [];
for($i=0; $i<20; $i++){
    $data[] = [
        'name'=>$faker->firstName(),
        'surname'=>$faker->lastName(),
        'patronymic'=>$faker->firstNameMale(),
    ];
}
return $data;
