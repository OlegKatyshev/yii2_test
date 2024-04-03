<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @param string $name
 * @param string $surname
 * @param string $patronymic
 */

class Authors extends ActiveRecord
{

    public static function tableName()
    {
        return 'authors';
    }

}