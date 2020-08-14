<?php

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

$this->title = 'Список расчетов';

?>

<div class="calc-list">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новый расчет', ['new-calc'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => SerialColumn::class],
            [
                'attribute' => 'settlement_month',
                'format' => ['date', 'php:F Y']
            ],
            'total:currency',
            'created_at'
        ]
    ]) ?>
</div>
