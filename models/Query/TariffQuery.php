<?php

namespace app\models\Query;

use app\models\Tariff;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Tariffs]].
 *
 * @see \app\models\Tariff
 */
class TariffQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tariff[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tariff|array|null
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
        $this->addOrderBy(['id' => SORT_DESC])->limit(1);

        return $this;
    }
}
