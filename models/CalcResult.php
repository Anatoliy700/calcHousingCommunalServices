<?php

namespace app\models;

use app\models\Query\CalcResultQuery;
use app\models\Query\MetersDataQuery;
use app\models\Query\TariffsQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%calc_result}}".
 *
 * @property int $id
 * @property int $current_meters_id
 * @property int $previous_meters_id
 * @property int $tariff_id
 * @property string $settlement_month
 * @property float $total
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Tariffs $tariff
 * @property MetersData $previousMeters
 * @property MetersData $currentMeters
 */
class CalcResult extends ActiveRecord
{
    public const SCENARIO_SAVE = 'save';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%calc_result}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['current_meters_id', 'previous_meters_id', 'tariff_id', 'settlement_month'], 'required'],
            [['total'], 'required', 'on' => static::SCENARIO_SAVE],
            [['current_meters_id', 'previous_meters_id', 'tariff_id'], 'integer'],
            [['settlement_month'], 'date', 'format' => 'php:Y-m-d'],
            [['created_at', 'updated_at'], 'safe'],
            [['total'], 'number'],
            [
                ['current_meters_id', 'previous_meters_id'],
                'unique',
                'targetAttribute' => ['current_meters_id', 'previous_meters_id'],
            ],
            [
                ['tariff_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Tariffs::class,
                'targetAttribute' => ['tariff_id' => 'id'],
            ],
            [
                ['previous_meters_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => MetersData::class,
                'targetAttribute' => ['previous_meters_id' => 'id'],
            ],
            [
                ['current_meters_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => MetersData::class,
                'targetAttribute' => ['current_meters_id' => 'id'],
            ],
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'current_meters_id' => 'Текущие показания',
            'previous_meters_id' => 'Предыдущие показания',
            'tariff_id' => 'Тариф',
            'settlement_month' => 'Расчетный месяц',
            'total' => 'Итого',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Tariff]].
     *
     * @return ActiveQuery|TariffsQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariffs::class, ['id' => 'tariff_id']);
    }

    /**
     * Gets query for [[PreviousMeters]].
     *
     * @return ActiveQuery|MetersDataQuery
     */
    public function getPreviousMeters()
    {
        return $this->hasOne(MetersData::class, ['id' => 'previous_meters_id']);
    }

    /**
     * Gets query for [[CurrentMeters]].
     *
     * @return ActiveQuery|MetersDataQuery
     */
    public function getCurrentMeters()
    {
        return $this->hasOne(MetersData::class, ['id' => 'current_meters_id']);
    }

    /**
     * {@inheritdoc}
     * @return CalcResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalcResultQuery(get_called_class());
    }
}
