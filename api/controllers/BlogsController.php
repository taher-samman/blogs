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
use common\models\Category;
use common\models\Comments;
use common\models\Likes;

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
    public $categoriesModel;
    public $likes;
    public $comments;
    public function __construct($id, $controller)
    {
        $this->id = $id;
        $this->controller = $controller;
        $this->categoriesModel = new Category();
        $this->blogsModel = new Blogs();
        $this->blogsImages = new BlogsImages();
        $this->connection = \Yii::$app->db;
        $this->likes = new Likes();
        $this->comments = new Comments();
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
                    'getblog' => ['get'],
                    'getcomments' => ['get'],
                    'update' => ['post'],
                    'addlike' => ['post'],
                    'removelike' => ['post'],
                    'addcomment' => ['post'],
                    'delete' => ['delete'],
                    'removeimage' => ['delete'],
                    'getlikes' => ['get']
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
    public function actionDelete($id)
    {
        $blog = $this->blogsModel->find()->where(['id' => $id])->one();
        $blog->delete();
    }
    public function actionGetlikes()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $result = [];
        $likes = $this->likes->find()->all();
        foreach ($likes as $key => $like) {
            if (empty($result[$like->blog_id])) {
                $result[$like->blog_id] = [
                    'users' => [$like->user],
                    'qty' => 1
                ];
            } else {
                array_push($result[$like->blog_id]['users'], $like->user);
                $result[$like->blog_id]['qty']++;
            }
        }
        $response->data = $result;
        return $response;
    }
    public function actionAddcomment()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $blogId = Yii::$app->request->post('id');
        $comment = Yii::$app->request->post('comment');
        $user_id = $this->getUser();
        $this->comments->blog_id = $blogId;
        $this->comments->comment = $comment;
        $this->comments->user_id = $user_id;
        if ($this->comments->save()) {
            $response->data = true;
        } else {
            $response->data = false;
            $response->statusCode = 401;
        }
        return $response;
    }
    public function actionGetcomments()
    {
        $result = [];
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $comments = $this->comments->find()->all();
        $response->data = [
            'status' => true,
            'data' => $comments
        ];
        return $response;
    }
    public function actionAddlike()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $blogId = Yii::$app->request->post('id');
        $user_id = $this->getUser();
        $this->likes->blog_id = $blogId;
        $this->likes->user_id = $user_id;
        if ($this->likes->save()) {
            $response->data = true;
        } else {
            $response->data = false;
            $response->statusCode = 401;
        }
        return $response;
    }
    public function actionRemovelike()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $blogId = Yii::$app->request->post('id');
        $user_id = $this->getUser();
        $like = $this->likes->find()->where(['blog_id' => $blogId, 'user_id' => $user_id])->one();
        if ($like->delete()) {
            $response->data = true;
        } else {
            $response->data = false;
            $response->statusCode = 401;
        }
        return $response;
    }
    public function actionRemoveimage($id)
    {
        $image = $this->blogsImages->find()->where(['id' => $id])->one();
        if ($image->delete()) {
            return true;
        }
        return false;
    }
    public function actionUpdate()
    {
        $user_id = $this->getUser();
        $result = [];
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $data = Yii::$app->request->post();
        $blog = $this->blogsModel->find()->where(['id' => $data['blog_id'], 'user_id' => $user_id])->one();
        if (!empty($blog)) {
            $blog->name = $data['name'];
            $blog->description = $data['description'];
            $blog->cat_id = $data['category'];

            $transaction = $this->connection->beginTransaction();
            try {
                if (strcmp($data['image'], 'null') != 0) {
                    $image = $this->blogsImages;
                    $image->blog_id = $blog->id;
                    $image->value = $data['image'];
                    $image->save();
                }
                $blog->save();
                //.... other SQL executions
                $transaction->commit();
                $result = [
                    'status' => true,
                    'id' => $blog->id
                ];
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
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
        $this->blogsImages->value = $data['image'];
        // ==}   
        // =============================================
        // load Blog Image Data {==
        // $image_generated_name = $this->uploadBlogImage($data['image']);
        // if (strlen($image_generated_name) > 0 && $image_generated_name != false) {
        //     $this->blogsImages->value = $image_generated_name;
        // } else {
        //     return false;
        // }
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
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $blog = [];
        $query = $this->blogsModel->find()
            ->where(['id' => $id])
            ->one();
        if (!empty($query)) {
            $user = User::findIdentity($query->user_id);
            $blog = [
                'id' => $query->id,
                'name' => $query->name,
                'user_id' => $query->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'description' => $query->description,
                'cat_id' => $query->cat_id,
                'cat_name' => $this->getCategory($query->cat_id),
                'image' => Yii::getAlias('@apiimages') . '/blogs/' . $this->getBlogImage($query->id)
            ];
        }

        if (count($blog) == 0) {
            $response->statusCode = 401;
            $blog = 'error';
        }
        $response->data = [
            'status' => true,
            'data' => $query
        ];
        return $response;
    }
    public function getCategory($id)
    {
        $category = $this->categoriesModel->find()->where(['id' => $id])->one();
        return $category->name;
    }
    public function getBlogImage($blog)
    {
        $image = $this->blogsImages->find()->where(['blog_id' => $blog])->one();
        return $image->value;
    }
}
