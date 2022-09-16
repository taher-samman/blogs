<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use backend\models\Category;

$categories = new Category();
$categories = $categories->find()->where(['<', 'id', $model->id ? $model->id : 0])->andWhere(['!=', 'id', $model->id ? $model->id : 0])->all();
$parents = [];
$parents[0] = 'No Parent';
foreach ($categories as $key => $categorie) {
    $parents[$categorie->id] = $categorie->name;
}
?>
<div class="<?= $type ?>-category">
    <div class="mt-5 offset-lg-1 col-lg-10">
        <h1 class="text-capitalize"><?= $type ?> category</h1>
        <?php $form = ActiveForm::begin(['id' => $type . '-category']); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['required' => true]) ?>
        <?= $form->field($model, 'image')->fileInput() ?>
        <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'value' => $model->sort ? $model->sort : 0]) ?>
        <?= $form->field($model, 'parent')->dropDownList($parents); ?>

        <div class="form-group">
            <?= Html::submitButton($type, ['class' => 'btn btn-primary btn-block text-capitalize', 'name' => $type . '-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>