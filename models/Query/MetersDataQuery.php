<?php

namespace app\models\Query;

/**
 * This is the ActiveQuery class for [[\app\models\MetersData]].
 *
 * @see \app\models\MetersData
 */
class MetersDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\MetersData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\MetersData|array|null
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

    /**
     * @param int $currentId
     * @return $this
     */
    public function previous(int $currentId): self
    {
        return $this->andWhere(['<', 'id', $currentId])->last();
    }
}
