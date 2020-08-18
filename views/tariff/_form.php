<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tariff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tariff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 't1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 't3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'col')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hot')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sewerage')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
