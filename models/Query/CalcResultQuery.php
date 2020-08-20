<?php

namespace app\models\Query;

/**
 * This is the ActiveQuery class for [[\app\models\CalcResult]].
 *
 * @see \app\models\CalcResult
 */
class CalcResultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\CalcResult[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\CalcResult|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function last(): self
    {
        return $this->addOrderBy(['id' => SORT_DESC])->limit(1);
    }
}
