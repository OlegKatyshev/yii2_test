<?php
use Faker\Factory;

$faker = Factory::create();
array_map('unlink', glob(Yii::getAlias('@app/web/img/*')));
$data = [];
for($i=0; $i<100; $i++){
    $data[] = [
        'title'=>$faker->sentence(3),
        'year'=>$faker->year(),
        'isbn'=>$faker->isbn13(),
        'picture'=>$faker->image('web/img', 100, 100, null, false, true, null, false, 'png'),
        'description'=>$faker->paragraph(),
    ];
}
return $data;