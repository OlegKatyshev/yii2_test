<?php

namespace app\models;

use yii\db\ActiveRecord;


/**
 * @param int $user_id
 * @param numeric $phone
 */
class Phones extends ActiveRecord
{
    public static function tableName()
    {
        return 'phones';
    }

    public function rules()
    {
        return [
            ['user_id', 'integer'],
            ['phone', 'string','length'=>11],
            ['phone', 'match', 'pattern' => '/^\d+$/'],
            ['phone', 'unique', 'filter'=>function($query){
                if(!empty($this->id)){
                    return $query->andWhere(['not', ['id'=>$this->id]]);
                }
            }],
        ];
    }
}