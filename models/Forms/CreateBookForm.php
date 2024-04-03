<?php

namespace app\models\Forms;

use app\models\Authors;
use yii\base\Model;
use app\models\Books;
use yii\helpers\ArrayHelper;

class CreateBookForm extends Model
{
    public $id;

    public $title;

    public $year;

    public $isbn;

    public $author_id;

    public $picture;

    public $description;

    public function rules()
    {
        return [
            [['title','year','isbn','description'], 'filter','skipOnEmpty'=>true, 'filter' => function ($value) {
                return trim(strip_tags($value));
            }],
            [['title','year','isbn','author_id'], 'required'],
            [['year','author_id','id'], 'integer'],
            ['picture', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024*2],
            ['title', 'string', 'length' => [4, 20]],
            ['description', 'string', 'length' => [5, 255]],
            ['isbn', 'string', 'length' => 13 ],
            ['isbn', 'match', 'pattern' => '/^\d+$/'],
            ['isbn', 'unique', 'targetClass' => Books::class, 'filter'=>function($query){
                    if(!empty($this->id)){
                        return $query->andWhere(['not', ['id'=>$this->id]]);
                    }
            } ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'year' => 'Год',
            'isbn' => 'код isbn',
            'author_id' => 'Автор',
            'picture'=>'Картинка',
            'description'=>'Описание',
        ];
    }

    public function getAuthorsList(): array {

        $data = Authors::find()->select(["id","CONCAT(name,' ', surname) as name"])->orderBy('id')->asArray()->all();
        return ArrayHelper::map($data,'id','name');
    }
}