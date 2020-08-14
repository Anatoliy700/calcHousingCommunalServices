<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MetersData */

$this->title = 'Добавить начальные показания счетчиков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meters-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
