<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    protected $logedHomeUrl;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'controllers' => ['site','authors','subscription'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'controllers' => ['authors','books','subscription'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['site'],
                        'actions'=>['logout','login'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if(!\Yii::$app->user->isGuest){

            $this->logedHomeUrl = \Yii::$app->getUrlManager()->createUrl(['books/index']);
            \Yii::$app->setHomeUrl($this->logedHomeUrl);
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}