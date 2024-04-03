<?php

namespace app\controllers;

use app\models\Authors;
use app\models\Books;
use app\models\Forms\AuthorsForm;
use Yii;
use yii\web\Response;

class AuthorsController extends BaseController
{
    /**
     * @return string|Response
     */
    public function actionIndex(){

        if(Yii::$app->request->isPost){

            Yii::$app->session->set('AuthorsForm', Yii::$app->request->post());
            return $this->refresh();
        }

        $formModel = new AuthorsForm();
        $years = Books::find()->select('year')->distinct()->orderBy('year')->column();
        $authors = [];

        if($formModel->load(Yii::$app->session->get('AuthorsForm')) && $formModel->validate()){

            $authors = Authors::find()
                ->select('authors.name, authors.surname, books.year, count(*) as cnt_publish')
                ->innerJoin('author_books','author_books.author_id = authors.id')
                ->innerJoin('books','author_books.book_id = books.id')
                ->where(['books.year'=>$formModel->year])
                ->groupBy('books.year, authors.name, authors.surname')
                ->orderBy('cnt_publish DESC')
                ->limit(10)
                ->asArray()
                ->all();
        }

        return $this->render('index', [
            'formModel'=>$formModel,
            'years' => $years,
            'authors'=>$authors
        ]);
    }

    /**
     * @return Response
     */
    public function actionClear(){
        Yii::$app->session->remove('AuthorsForm');
        return $this->redirect(['authors/index']);
    }
}