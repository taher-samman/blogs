<?php

namespace api\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use common\models\Blogs;

/**
 * Site controller
 */
class BlogsController extends Controller
{
    public $controller;
    public $id;
    public $blogsModel;
    public function __construct($id, $controller)
    {
        $this->id = $id;
        $this->controller = $controller;
        $this->blogsModel = new Blogs();
        parent::__construct($id, $controller);
    }
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin'                           => ['http://localhost:4200'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post']
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'except' => [],
                'authMethods' => [
                    HttpBasicAuth::className(),
                    HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        $result = [];
        $model = new Blogs();
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $model->name = Yii::$app->request->post('name');
        $model->slug = Yii::$app->request->post('name');
        $model->description = Yii::$app->request->post('description');
        $model->cat_id = Yii::$app->request->post('categories');
        $model->user_id = Yii::$app->request->post(1);
        $model->save();
        $response->data = $result;
        return $response;
    }
}
