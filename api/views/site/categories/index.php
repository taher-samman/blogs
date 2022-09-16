<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
?>
<?php

function getCategories($model, $parentId)
{
    $categories = $model->find()
        ->where(['parent' => $parentId])
        ->all();
    $html = '<ul class="list-group list-group-flush">';
    foreach ($categories as $category) {
        $html .= '<li class="list-group-item"><a class="link-success text-decoration-none" href="' . Url::toRoute('site/category/' . $category->id) . '">';
        $html .= $category->name;
        $html .= getCategories($model, $category->id);
        $html .= '</li></a>';
    }
    $html .= '</ul>';
    return $html;
}
?>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php }
?>
<?php
if (Yii::$app->session->hasFlash('error')) { ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php }
?>
<div class="toolbar text-end p-2" style="border-bottom: 1px solid #d54721;">
    <a class="btn btn-primary" style="background-color: #246fa7;" href="<?= Url::toRoute('addcategory') ?>">
        Add
    </a>
</div>
<div class="row flex-grow-1">
    <div class="col-md-3" style="border-right: 1px solid #d54721;">
        <?= getCategories($model, 0) ?>
    </div>
    <div class="col-md-8">
        <?php
        if (Yii::$app->session->hasFlash('updated')) { ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('updated') ?>
            </div>
        <?php }
        ?>
        <?php
        if (isset($catId) && isset($form)) { ?>
            <?= $form ?>
        <?php }
        ?>
    </div>
</div>