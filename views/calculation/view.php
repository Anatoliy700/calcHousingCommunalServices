<?php

use app\Services\CalculateService;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $calcService CalculateService
 */

$this->title = $calcService->getSettlementMonth();
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="calc-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <thead>
        <th>Название</th>
        <th><?= $calcService->getLabel('current_meters_id') ?></th>
        <th><?= $calcService->getLabel('previous_meters_id') ?></th>
        <th>Вычеслено</th>
        <th><?= $calcService->getLabel('tariff_id') ?></th>
        <th>Стоимость</th>
        </thead>
        <tr>
            <td><?= $calcService->getLabel('t1') ?></td>
            <td><?= $calcService->getCurrentT1() ?></td>
            <td><?= $calcService->getPreviewT1() ?></td>
            <td><?= $calcService->getDiffT1() ?></td>
            <td><?= $calcService->getTariffT1('currency') ?></td>
            <td><?= $calcService->getCostT1('currency') ?></td>
        </tr>
        <tr>
            <td><?= $calcService->getLabel('t2') ?></td>
            <td><?= $calcService->getCurrentT2() ?></td>
            <td><?= $calcService->getPreviewT2() ?></td>
            <td><?= $calcService->getDiffT2() ?></td>
            <td><?= $calcService->getTariffT2('currency') ?></td>
            <td><?= $calcService->getCostT2('currency') ?></td>
        </tr>
        <tr>
            <td><?= $calcService->getLabel('t3') ?></td>
            <td><?= $calcService->getCurrentT3() ?></td>
            <td><?= $calcService->getPreviewT3() ?></td>
            <td><?= $calcService->getDiffT3() ?></td>
            <td><?= $calcService->getTariffT3('currency') ?></td>
            <td><?= $calcService->getCostT3('currency') ?></td>
        </tr>
        <tr>
            <td><?= $calcService->getLabel('col') ?></td>
            <td><?= $calcService->getCurrentCol() ?></td>
            <td><?= $calcService->getPreviewCol() ?></td>
            <td><?= $calcService->getDiffCol() ?></td>
            <td><?= $calcService->getTariffCol('currency') ?></td>
            <td><?= $calcService->getCostCol('currency') ?></td>
        </tr>
        <tr>
            <td><?= $calcService->getLabel('hot') ?></td>
            <td><?= $calcService->getCurrentHot() ?></td>
            <td><?= $calcService->getPreviewHot() ?></td>
            <td><?= $calcService->getDiffHot() ?></td>
            <td><?= $calcService->getTariffHot('currency') ?></td>
            <td><?= $calcService->getCostHot('currency') ?></td>
        </tr>
        <tr>
            <td><?= $calcService->getLabel('sewerage') ?></td>
            <td><?= $calcService->getCurrentSewerage() ?></td>
            <td><?= $calcService->getPreviewSewerage() ?></td>
            <td><?= $calcService->getDiffSewerage() ?></td>
            <td><?= $calcService->getTariffSewerage('currency') ?></td>
            <td><?= $calcService->getCostSewerage('currency') ?></td>
        </tr>
        <tr style="font-weight: bold">
            <td style="text-align: right" colspan="5"><?= $calcService->getLabel('total') ?>:</td>
            <td><?= $calcService->getCostTotal('currency') ?></td>
        </tr>
    </table>
</div>
