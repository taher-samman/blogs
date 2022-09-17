<?php

namespace api\controllers;

use common\models\Blogs;
use common\models\Category;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $controller;
    public $id;
    public $categoriesModel;
    public function __construct($id, $controller)
    {
        $this->id = $id;
        $this->controller = $controller;
        $this->categoriesModel = new Category();
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
                    'getcategories' => ['get'],
                    'getblogs' => ['get'],
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'except' => ['index'],
                'authMethods' => [
                    HttpBasicAuth::className(),
                    HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return 'Site Index';
    }
    public function categoriesFamily($parent)
    {
        $result = [];
        $categories = $this->categoriesModel
            ->find()
            ->where(['enabled' => 1])
            ->andWhere(['parent' => $parent])
            ->orderBy('sort')
            ->all();
        if (count($categories) > 0) {
            foreach ($categories as $key => $category) {
                $result[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image,
                    'children' => $this->categoriesFamily($category->id)
                ];
            }
        }
        return $result;
    }
    public function actionGetcategories()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $result = [];
        $result = [
            'status' => true,
            'data' => $this->categoriesFamily(0)
        ];
        if (count($result) == 0) {
            // $response->statusCode = 401;
            $result = ['Ma 3na Categories'];
        }
        $response->data = $result;
        return $response;
    }
    public function getUser()
    {
        $auth_key = \str_replace('Bearer ', '', Yii::$app->request->getHeaders()->get('Authorization'));
        return User::findIdentityByAccessToken($auth_key)->id;
    }
    public function actionGetblogs()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $blogs = [];
        $model = new Blogs();
        $query = $model->find()->where(['user_id' => 1])->andWhere(['enabled' => 1])->all();
        foreach ($query as $key => $blog) {
            $blogs[] = [
                'id' => $blog->id,
                'name' => $blog->name,
                'description' => $blog->description,
                'cat_id' => $blog->cat_id
            ];
        }
        if (count($blogs) == 0) {
            // $response->statusCode = 401;
            $blogs = ['Ma 3na Bloget'];
        }
        $response->data = [
            'status' => true,
            'data' => $blogs
        ];
        return $response;
    }
}
