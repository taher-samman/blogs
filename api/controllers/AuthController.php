<?php

namespace api\controllers;

use common\models\User;
use yii\web\Controller;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use api\models\SignupForm;

/**
 * Site controller
 */
class AuthController extends Controller
{
    private $username;
    private $email;
    private $password;

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
                    'login' => ['post'],
                    'register' => ['post']
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'except' => ['login', 'register'],
                'authMethods' => [
                    HttpBasicAuth::className(),
                    HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $this->username = Yii::$app->request->post('username');
        $this->password = Yii::$app->request->post('password');
        $result = [];
        $modelUser = User::findByUsername($this->username);
        if ($modelUser) {
            if ($modelUser->validatePassword($this->password)) {
                $result = [
                    'status' => true,
                    'token' => $modelUser->auth_key,
                    'user' => ['id' => $modelUser->id, 'username' => $modelUser->username, 'email' => $modelUser->email]
                ];
            } else {
                $response->statusCode = 401;
                $result = [
                    'status' => false,
                    'message' => 'password incorrect'
                ];
            }
        } else {
            $response->statusCode = 401;
            $result = [
                'status' => false,
                'message' => 'username incorrect'
            ];
        }
        $response->data = $result;
        return $response;
    }
    public function actionRegister()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->statusCode = 200;
        $this->username = Yii::$app->request->post('username');
        $this->email = Yii::$app->request->post('email');
        $this->password = Yii::$app->request->post('password');

        $model = new SignupForm();
        if ($model->signup($this->username, $this->email, $this->password)) {
            return $this->actionLogin();
        } else {
            $response->statusCode = 401;
            $result = [
                'status' => false,
                'message' => 'Can\'t register'
            ];
        }
        $response->data = $result;
        return $response;
    }
}
