<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @param int $author_id
 * @param int $phone_id
 */
class Subscriptions extends ActiveRecord
{
    public static function tableName()
    {
        return 'subscriptions';
    }

    public function rules()
    {
        return [
            [['phone_id','author_id'], 'integer'],
        ];
    }
}