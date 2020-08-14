<?php

/**
 * @var $this yii\web\View
 * @var $calcModel \app\models\CalcResult
 * @var $metersModel \app\models\MetersData
 * @var $lastMetersModel \app\models\MetersData
 */

use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Новый расчет';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="new-calc">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($calcModel, 'settlement_month')
        ->widget(DateControl::class, [
            'type' => DateControl::FORMAT_DATE,
            'displayFormat' => 'php:F Y',
            'saveFormat' => 'php:Y-m-d',
            'language' => 'ru',
            'widgetOptions' => [
                'type' => DatePicker::TYPE_INPUT,
                'options' => [
                    'autocomplete' => 'off',
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                ],
            ],
        ]) ?>
    <?= $form->field($metersModel, 't1')->textInput(['placeholder' => $lastMetersModel->t1]) ?>
    <?= $form->field($metersModel, 't2')->textInput(['placeholder' => $lastMetersModel->t2]) ?>
    <?= $form->field($metersModel, 't3')->textInput(['placeholder' => $lastMetersModel->t3]) ?>
    <?= $form->field($metersModel, 'col')->textInput(['placeholder' => $lastMetersModel->col]) ?>
    <?= $form->field($metersModel, 'hot')->textInput(['placeholder' => $lastMetersModel->hot]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
