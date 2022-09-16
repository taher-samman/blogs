<?php

namespace backend\controllers;

use common\models\AdminLoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\Category;
use backend\models\UploadForm;
use yii\filters\Cors;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $controller;
    public $id;
    public $categoriesModel;
    public $uploader;
    public function __construct($id, $controller)
    {
        $this->id = $id;
        $this->controller = $controller;
        $this->categoriesModel = new Category();
        $this->uploader = new UploadForm();
        parent::__construct($id, $controller);
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'categories', 'addcategory', 'category', 'test'],
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
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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
    public function actionCategories()
    {
        $model = $this->categoriesModel;
        return $this->render('categories/index', [
            'model' => $model,
        ]);
    }
    public function actionAddcategory()
    {
        $uploader = $this->uploader;
        $model = $this->categoriesModel;
        if ($model->load(Yii::$app->request->post())) {
            $uploader->imageFile = UploadedFile::getInstance($model, 'image');
            if (strlen($uploader->imageFile) > 0) {
                if ($uploader->upload()) {
                    $model->image = $uploader->imageFile;
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Category Added Succesfly');
                } else {
                    Yii::$app->session->setFlash('error', 'Image Not Uploaded');
                }
            } else {
                $model->save();
                Yii::$app->session->setFlash('success', 'Category Added Succesfly');
            }
            return $this->redirect(['categories']);
        }
        $form = $this->getView()->render('categories/form', [
            'model' => $model,
            'type' => 'add'
        ], $this);
        return $this->render('categories/add', [
            'model' => $model,
            'form' => $form
        ]);
    }
    public function actionCategory($id)
    {
        $uploader = $this->uploader;
        $model = $this->categoriesModel;
        $model = $model->find()->where(['id' => $id])->one();
        if ($model === null) {
            return $this->render('categories/index', [
                'model' => $model,
                'type' => 'edit'
            ]);
        }
        if ($model->load(Yii::$app->request->post())) {
            $uploader->imageFile = UploadedFile::getInstance($model, 'image');
            if (strlen($uploader->imageFile) > 0) {
                if ($uploader->upload()) {
                    $model->image = $uploader->imageFile;
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Category Updated Succesfly');
                } else {
                    Yii::$app->session->setFlash('error', 'Image Not Uploaded');
                }
            } else {
                $model->save();
                Yii::$app->session->setFlash('success', 'Category Updated Succesfly');
            }
        }
        $form = $this->getView()->render('categories/form', [
            'model' => $model,
            'type' => 'edit'
        ], $this);
        return $this->render('categories/index', [
            'model' => $model,
            'catId' => $id,
            'form' => $form
        ]);
    }
    public function actionTest()
    {
        return 'test api';
    }
}
