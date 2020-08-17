<?php

namespace app\models;

use app\models\Query\TariffsQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%tariffs}}".
 *
 * @property int $id
 * @property float $t1
 * @property float $t2
 * @property float $t3
 * @property float $col
 * @property float $hot
 * @property float $sewerage
 * @property string $created_at
 * @property string $updated_at
 */
class Tariffs extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%tariffs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['t1', 't2', 't3', 'col', 'hot', 'sewerage'], 'required'],
            [['t1', 't2', 't3', 'col', 'hot', 'sewerage'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @return array|array[]
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression("datetime('now')"),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            't1' => 'Электричество T1',
            't2' => 'Электричество T2',
            't3' => 'Электричество T3',
            'col' => 'Холодная',
            'hot' => 'Горячая',
            'sewerage' => 'Канализация',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TariffsQuery the active query used by this AR class.
     */
    public static function find(): TariffsQuery
    {
        return new TariffsQuery(get_called_class());
    }

    /**
     * @return static|null
     */
    public static function getLast(): ?self
    {
        return static::find()->last()->one();
    }
}
