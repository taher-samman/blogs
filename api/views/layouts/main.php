<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\helpers\BaseUrl;
use yii\helpers\Url;

$this->title = 'Dashboard';
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <main role="main" class="flex-shrink-0 h-100">
        <div class="container-fluid p-0 h-100 d-flex flex-column">
            <div class="banner w-100 p-0">
                <div class="banner-img w-100 p-0">
                    <a href="<?= BaseUrl::base() ?>" class="d-block w-100">
                        <img src="<?= Url::to('@web/uploads/static/yiiimg.jpg', true); ?>" class="w-100" alt="banner">
                    </a>
                </div>
            </div>
            <div class="row flex-nowrap m-0 flex-grow-1">
                <div class="col-md-2 p-5" style="background-color: #c7e686">
                    <div class="d-flex flex-column align-items-center h-100">
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="<?= Url::toRoute('categories') ?>" class="nav-link p-0">
                                    <h2 style="color: #246fa7;">Categories</h2>
                                </a>
                            </li>
                        </ul>
                        <hr>
                    </div>
                </div>
                <div class="col-md-10 p-5 d-flex flex-column">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
