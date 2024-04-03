<?php

namespace app\controllers;

use app\models\Books;
use app\models\Forms\LoginForm;
use Yii;
use yii\data\Pagination;
use yii\web\Response;

class SiteController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Books::find()->select([
            'id',
            'title',
            'year',
            'picture',
            'description'
        ]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount'=>$countQuery->count(),'pageSize'=>15]);
        $books = $query->with('authors')->offset($pages->offset)->limit($pages->limit)->orderBy('id')->all();

        return $this->render('index',['books' => $books, 'pages'=>$pages]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack($this->logedHomeUrl);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
