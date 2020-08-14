<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MetersData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meters-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 't1')->textInput() ?>

    <?= $form->field($model, 't2')->textInput() ?>

    <?= $form->field($model, 't3')->textInput() ?>

    <?= $form->field($model, 'col')->textInput() ?>

    <?= $form->field($model, 'hot')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
