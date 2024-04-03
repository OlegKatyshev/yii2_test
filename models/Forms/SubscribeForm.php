<?php

namespace app\models\Forms;

use yii\base\Model;


/**
 * @param numeric $phone
 * @param array $book_id
 */
class SubscribeForm extends Model
{
    public $book_id;

    public $phone;

    public function rules()
    {
        return [
            ['book_id', 'integer'],
            ['phone', 'string','length'=>11],
            ['phone', 'match', 'pattern' => '/^\d+$/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
        ];
    }
}