<?php

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

$this->title = 'Список расчетов';

?>

<div class="calc-list">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новый расчет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => SerialColumn::class],
            [
                'attribute' => 'settlement_month',
                'format' => ['date', 'LLLL y'],
            ],
            'total:currency',
            'created_at:datetime',
            [
                'class' => ActionColumn::class,
                'template' => '{view}',
            ],
        ],
    ]) ?>
</div>
