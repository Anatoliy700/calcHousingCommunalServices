<?php

namespace app\models\Query;

use app\models\Tariffs;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Tariffs]].
 *
 * @see \app\models\Tariffs
 */
class TariffsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tariffs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tariffs|array|null
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
