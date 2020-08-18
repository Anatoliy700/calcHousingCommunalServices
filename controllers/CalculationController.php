<?php

namespace app\controllers;

use app\models\CalcResult;
use app\models\MetersData;
use app\models\Tariff;
use app\Services\CalculateService;
use yii\base\ExitException;
use yii\data\ActiveDataProvider;
use yii\db\Connection;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class CalculationController extends Controller
{

    /**
     * @return string
     * @throws ExitException
     */
    public function actionIndex(): string
    {
        try {
            $dataProvider = new ActiveDataProvider([
                'query' => CalcResult::find(),
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } catch (Exception $e){
               throw new ExitException('Не установлены миграции. Выполните в консоли "php yii migrate"');
        }
    }

    /**
     * @param int $id
     * @return string|Response
     */
    public function actionView(int $id)
    {
        try {
            $model = $this->findModel($id);
            $calculateService = new CalculateService($model);

            return $this->render('view', ['calcService' => $calculateService]);
        } catch (\Exception $e) {
            $this->showMessage('error', $e->getMessage());

            return $this->redirect(['index']);
        }
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $calcModel = new CalcResult();
        $metersModel = new MetersData();
        $request = $this->getRequest();

        try {
            if ($request->isPost && $metersModel->load($request->post()) && $calcModel->load($request->post()) && $metersModel->validate()) {
                if (!$tariff = Tariff::getLast()) {
                    $this->showMessage('warning', 'Не найден тариф');

                    return $this->redirect(['tariff/create']);
                }
                $transaction = $this->getDb()->beginTransaction();
                if ($metersModel->save()) {
                    $calcModel->current_meters_id = $metersModel->id;
                    $calcModel->previous_meters_id = $metersModel->getPrevious()->id;
                    $calcModel->tariff_id = $tariff->id;

                    $calcService = new CalculateService($calcModel);
                    $calcModel->total = $calcService->getCostTotal();
                    $calcModel->setScenario(CalcResult::SCENARIO_SAVE);

                    if (!$calcModel->save()) {
                        throw new \Exception();
                    }
                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $calcModel->id]);

                } else {
                    throw new \Exception();
                }
            }
        } catch (\Exception $e) {
            if (isset($transaction)) {
                $transaction->rollBack();
                $this->showMessage('error', $e->getMessage());
            }
        }

        if (!$lastMetersModel = MetersData::getLast()) {
            $this->showMessage('warning', 'Не найдены предыдущие показания счетчиков');

            return $this->redirect(['meters-data/create']);
        }

        return $this->render('create', [
            'calcModel' => $calcModel,
            'metersModel' => $metersModel,
            'lastMetersModel' => $lastMetersModel,
        ]);
    }


    /**
     * @param $id
     * @return CalcResult
     * @throws NotFoundHttpException
     */
    protected function findModel($id): CalcResult
    {
        if (($model = CalcResult::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return Connection
     */
    protected function getDb(): Connection
    {
        return \Yii::$app->getDb();
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return \Yii::$app->getRequest();
    }

    /**
     * @param string $type
     * @param string $message
     */
    protected function showMessage(string $type, string $message): void
    {
        \Yii::$app->session->setFlash($type, $message);
    }
}
