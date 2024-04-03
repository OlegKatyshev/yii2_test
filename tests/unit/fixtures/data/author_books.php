<?php
use Faker\Factory;
use app\models\Books;
use app\models\Authors;

$faker = Factory::create();
$books = Books::find()->select('id')->orderBy('id')->column();
$author_max_id = Authors::find()->max('id');
$author_min_id = Authors::find()->min('id');
$data = [];

foreach ($books as $book_id){

    $author_id = $faker->numberBetween($author_min_id, $author_max_id);

    $data[]=[
        'book_id'=>$book_id,
        'author_id'=>$author_id,
    ];
    if($faker->randomDigit() > 5){

        $author_id2 = $faker->numberBetween($author_min_id, $author_max_id);
        $data[]=[
            'book_id'=>$book_id,
            'author_id'=> ($author_id2 === $author_id) ? $faker->numberBetween($author_min_id, $author_max_id) : $author_id2,
        ];
    }
}

return $data;