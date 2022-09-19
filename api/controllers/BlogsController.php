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
use common\models\BlogsImages;
use common\models\User;

/**
 * Site controller
 */
class BlogsController extends Controller
{
    public $controller;
    public $id;
    public $blogsModel;
    public $uploader;
    public $connection;
    public $blogsImages;
    public function __construct($id, $controller)
    {
        $this->id = $id;
        $this->controller = $controller;
        $this->blogsModel = new Blogs();
        $this->blogsImages = new BlogsImages();
        $this->connection = \Yii::$app->db;
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
                    'upload' => ['post'],
                    'getblog' => ['get']
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
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $id = $this->insertTransaction();
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
        $response->data = $result;
        return $response;
    }
    public function getUser()
    {
        $auth_key = \str_replace('Bearer ', '', Yii::$app->request->getHeaders()->get('Authorization'));
        return User::findIdentityByAccessToken($auth_key)->id;
    }
    public function insertTransaction()
    {
        $data = Yii::$app->request->post();
        // Load Blog Data {==
        $this->blogsModel->name = $data['name'];
        $this->blogsModel->description = $data['description'];
        $this->blogsModel->cat_id = $data['category'];
        $this->blogsModel->user_id = $this->getUser();
        // ==}   
        // =============================================
        // load Blog Image Data {==
        $image_generated_name = $this->uploadBlogImage($data['image']);
        if (strlen($image_generated_name) > 0 && $image_generated_name != false) {
            $this->blogsImages->value = $image_generated_name;
        } else {
            return false;
        }
        // ==}   
        $transaction = $this->connection->beginTransaction();
        try {
            $this->blogsModel->save();
            $this->blogsImages->blog_id = $this->blogsModel->id;
            $this->blogsImages->save();
            //.... other SQL executions
            $transaction->commit();
            return $this->blogsImages->blog_id;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function actionGetblog($id)
    {
        $user_id = $this->getUser();
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $blog = [];
        $query = $this->blogsModel->find()
            ->where(['user_id' => $user_id, 'id' => $id])
            ->one();
        $blog = [
            'id' => $query->id,
            'name' => $query->name,
            'description' => $query->description,
            'cat_id' => $query->cat_id,
            'image' => $this->getBlogImage($query->id)
        ];
        if (count($blog) == 0) {
            $response->statusCode = 401;
            $blog = 'error';
        }
        $response->data = [
            'status' => true,
            'data' => $blog
        ];
        return $response;
    }
    public function getBlogImage($blog)
    {
        $image = $this->blogsImages->find()->where(['blog_id' => $blog])->one();
        return $image->value;
    }
    // public function insertBlog($data)
    // {
    //     $this->blogsModel->name = $data['name'];
    //     $this->blogsModel->description = $data['description'];
    //     $this->blogsModel->cat_id = $data['category'];
    //     $this->blogsModel->user_id = $this->getUser();
    //     if (!$this->blogsModel->save()) {
    //         return false;
    //     }
    //     return $this->blogsModel->id;
    // }
    public function uploadBlogImage($base64)
    {
        $image_parts = explode(";base64,", $base64);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image_name = uniqid() . '.' . $image_type;
        $file = Yii::getAlias('uploads/blogs/' . $image_name);
        if (file_put_contents($file, $image_base64)) {
            return $image_name;
        }
        return false;
    }
}
