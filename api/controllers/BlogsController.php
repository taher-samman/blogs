<?php

namespace api\controllers;

use backend\models\UploadForm;
use yii\web\Controller;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use common\models\Blogs;
use common\models\BlogsImages;
use common\models\User;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class BlogsController extends Controller
{
    public $controller;
    public $id;
    public $blogsModel;
    public $uploader;
    public function __construct($id, $controller)
    {
        $this->id = $id;
        $this->controller = $controller;
        $this->blogsModel = new Blogs();
        $this->uploader = new UploadForm();
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
                    'add' => ['post'],
                    'upload' => ['post']
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
    public function actionUpload()
    {
        $data = Yii::$app->request->post();
        if (empty($data)) {
            echo 'data empty';
        }
        $model = new BlogsImages();
        if ($model->load($data, 'upload')) {
            echo $model->blog_id;
            echo $model->value;
            $model->save();
            return true;
        }
        return false;
    }
    public function actionAdd()
    {
        $result = [];
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $id = $this->insertBlog(Yii::$app->request->post());
        if ($id > 0 && $id != false) {
            // upload image here
            $result = [
                'status' => true,
                'id' => $id
            ];
        } else {
            $result = [
                'status' => \false
            ];
            $response->statusCode = 401;
        }
        // if (!$this->uploadBlogImage(Yii::$app->request->post('image'))) {
        //     $response->statusCode = 401;
        // }
        $response->data = $result;
        return $response;
    }
    public function getUser()
    {
        $auth_key = \str_replace('Bearer ', '', Yii::$app->request->getHeaders()->get('Authorization'));
        return User::findIdentityByAccessToken($auth_key)->id;
    }
    // public function uploadBlogImage($image)
    // {
    //     echo 'uploadBlogImage';
    //     $uploader = $this->uploader;
    //     $uploader->imageFile = UploadedFile::getInstanceByName('image');
    //     if ($uploader->upload()) {
    //         return true;
    //     }
    //     return false;
    // }
    public function insertBlog($data)
    {
        $this->blogsModel->name = $data['name'];
        $this->blogsModel->description = $data['description'];
        $this->blogsModel->cat_id = $data['category'];
        $this->blogsModel->user_id = $this->getUser();
        if (!$this->blogsModel->save()) {
            return false;
        }
        return $this->blogsModel->id;
    }
}
