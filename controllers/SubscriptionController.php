<?php

namespace app\controllers;

use Yii;
use app\models\AuthorBooks;
use app\models\Phones;
use app\models\Forms\SubscribeForm;
use app\services\SubscribeServise;

class SubscriptionController extends BaseController
{

    private $subscribeServise;

    public function __construct($id, $module,  SubscribeServise $service)
    {
        parent::__construct($id, $module);
        $this->subscribeServise = $service;
    }

    public function actionIndex(){

        $formModel = new SubscribeForm();
        $formModel->book_id = Yii::$app->request->get('book_id');

        if(Yii::$app->request->isPost && $formModel->load(Yii::$app->request->post()) && $formModel->validate()) {

            $transaction = Phones::getDb()->beginTransaction();
            try {

                $authorsId = AuthorBooks::find()->select('author_id')->where(['book_id' => $formModel->book_id])->column();
                if (empty($authorsId)) throw new \Exception('Ошибка оформления подписки.');

                $modelPhone = $this->subscribeServise->getPhone($formModel->phone);

                $authorsIdSubscribed = [];

                if (!empty($modelPhone)) {
                    $authorsIdSubscribed = $this->subscribeServise->alreadySubscribedTo($modelPhone);
                }
                else {
                    $modelPhone = $this->subscribeServise->createPhone($formModel->phone);
                }

                $authorsId = array_diff($authorsId, $authorsIdSubscribed);
                $this->subscribeServise->subscribe($authorsId, $modelPhone);

                $transaction->commit();
                Yii::$app->session->setFlash('success','Подписка оформлена');
                return $this->goHome();
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('index',['formModel' => $formModel]);
    }
}