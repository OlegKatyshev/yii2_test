<?php

namespace app\services;

use app\models\Phones;
use app\models\Subscriptions;

class SubscribeServise
{

    public function getPhone($phone){
       return Phones::findOne(['phone'=>$phone]);
    }

    public function createPhone($phone): Phones{

        $modelPhone = new Phones();
        $modelPhone->user_id = \Yii::$app->user->getId();
        $modelPhone->phone = $phone;
        $modelPhone->save();

        return $modelPhone;
    }

    public function alreadySubscribedTo( Phones $phone): array {

        return Subscriptions::find()
            ->select('author_id')
            ->where(['phone_id'=>$phone->id])
            ->asArray()
            ->column();
    }

    public function subscribe(array $authors_id, Phones $phone){

        if(!empty($authors_id) && !empty($phone)){
            $data = [];
            foreach ($authors_id as $id){
                $data[]=[$phone->id, $id];
            }
            \Yii::$app->db->createCommand()
                ->batchInsert(Subscriptions::tableName(),['phone_id','author_id'], $data)
                ->execute();
        }
    }
}