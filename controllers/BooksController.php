<?php

namespace app\controllers;

use Yii;
use app\models\Books;
use app\models\AuthorBooks;
use yii\data\Pagination;
use app\models\Forms\CreateBookForm;
use yii\web\UploadedFile;
use app\services\BookCreatorService;


class BooksController extends BaseController
{
    private $bookCreatorService;

    public function __construct($id, $module,  BookCreatorService $service)
    {
        parent::__construct($id, $module);
        $this->bookCreatorService = $service;
    }

    public function actionIndex(){

        $query = Books::find()->select([
            'id',
            'title',
            'year',
            'picture',
            'description'
        ]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount'=>$countQuery->count(),'pageSize'=>15]);
        $books = $query->with('authors')->offset($pages->offset)->limit($pages->limit)->orderBy('id DESC')->all();

        return $this->render('index',['books' => $books, 'pages'=>$pages]);
    }

    public function actionDelete(int $id){

        $transaction = Books::getDb()->beginTransaction();

        try {

            AuthorBooks::deleteAll(['book_id'=>$id]);
            Books::deleteAll(['id'=>$id]);
            $transaction->commit();
            Yii::$app->session->setFlash('success','Данные удалены');
        }
        catch (\Exception $e){
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger','Ошибка удаления');
        }
        finally {
            return $this->redirect(['books/index']);
        }
    }

    public function actionEdit(int $id){

        $formModel = new CreateBookForm();
        $book = Books::findOne($id);
        $formModel->attributes = $book->getAttributes();

        if (Yii::$app->request->isPost) {

            $formModel->load(Yii::$app->request->post());
            $formModel->picture = UploadedFile::getInstance($formModel, 'picture');

            if($formModel->validate()){
                try {

                    $this->bookCreatorService->loadModels($book, new AuthorBooks(), $formModel);
                    $this->bookCreatorService->update();
                    Yii::$app->session->setFlash('success','Книга изменена');
                }
                catch (\Exception $e){
                    Yii::$app->session->setFlash('danger', $e->getMessage());
                }
                finally
                {
                    return $this->refresh();
                }
            }
        }

        return $this->render('create', [
            'formModel'=> $formModel,
        ]);
    }

    public function actionCreate(){

        $formModel = new CreateBookForm();

        if (Yii::$app->request->isPost) {
            $formModel->load(Yii::$app->request->post());
            $formModel->picture = UploadedFile::getInstance($formModel, 'picture');

            if ($formModel->validate()) {

                try {

                    $this->bookCreatorService->loadModels(new Books(), new AuthorBooks(), $formModel);
                    $this->bookCreatorService->save();
                    Yii::$app->session->setFlash('success', 'Книга создана');
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('danger', 'Ошибка сохранений данных');
                } finally {
                    return $this->refresh();
                }
            }
        }

        return $this->render('create', [
            'formModel'=> $formModel,
        ]);
    }
}