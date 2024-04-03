<?php

namespace app\models;

use yii\db\ActiveRecord;


/**
 * @param int $id
 * @param string $username
 * @param string $password
 * @param string $authKey
 * @param string $accessToken
 */
class Users extends ActiveRecord
{

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username','password','authKey','accessToken'], 'trim'],
            [['username','password'], 'required'],
            ['username', 'string', 'max'=>20],
            [['username','accessToken'], 'unique'],
            [['password','authKey','accessToken'], 'string', 'max'=>35],
        ];
    }
}