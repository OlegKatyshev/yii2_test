<?php

namespace app\models\Forms;

use yii\base\Model;

class AuthorsForm extends Model
{
    public $year;

    public function rules()
    {
        return [
            ['year', 'integer'],
        ];
    }

}