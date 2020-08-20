<?php

namespace app\models;

use app\models\Query\CalcResultQuery;
use app\models\Query\MetersDataQuery;
use app\models\Query\TariffQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\FormatConverter;

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
 * @property Tariff $tariff
 * @property MetersData $previousMeters
 * @property MetersData $currentMeters
 */
class CalcResult extends ActiveRecord
{
    public const SCENARIO_SAVE = 'save';

    public const DATE_FORMAT_SAVE = 'php:Y-m-d';
    public const DATE_FORMAT_VIEW = 'LLLL y';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%calc_result}}';
    }

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function rules()
    {
        return [
            [['current_meters_id', 'previous_meters_id', 'tariff_id', 'settlement_month'], 'required'],
            [['total'], 'required', 'on' => static::SCENARIO_SAVE],
            [['current_meters_id', 'previous_meters_id', 'tariff_id'], 'integer'],
            [
                ['settlement_month'],
                'date',
                'format' => static::DATE_FORMAT_SAVE,
                'min' => $this->getNextMonth(),
                'max' => $this->getNextMonth(),
                'tooSmall' => 'Следующий месяц должен быть "' . $this->getNextMonth(static::DATE_FORMAT_VIEW) . '"',
                'tooBig' => 'Следующий месяц должен быть "' . $this->getNextMonth(static::DATE_FORMAT_VIEW) . '"',
                'on' => static::SCENARIO_SAVE,
            ],
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
                'targetClass' => Tariff::class,
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
     * @param string $format
     * @return string|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getNextMonth(string $format = self::DATE_FORMAT_SAVE): ?string
    {
        $date = null;

        if ($last = static::getLast()) {
            $saveFormat = $this->prepareFormat(static::DATE_FORMAT_SAVE);
            $dateTime = \DateTime::createFromFormat($saveFormat, $last->settlement_month);
            $dateTime->modify('+1 month');
            $date = \Yii::$app->formatter->asDate($dateTime, $format);
        }

        return $date;
    }

    /**
     * @param string $format
     * @return string
     */
    protected function prepareFormat(string $format): string
    {
        if (strncmp($format, 'php:', 4) === 0) {
            $format = substr($format, 4);
        } else {
            $format = FormatConverter::convertDateIcuToPhp($format, 'date');
        }

        return $format;
    }

    /**
     * @return $this
     * @throws \yii\base\InvalidConfigException
     */
    public function fillSettleMonth(): self
    {
        if ($nextMonth = $this->getNextMonth()) {
            $this->settlement_month = $nextMonth;
        }

        return $this;
    }

    /**
     * Gets query for [[Tariff]].
     *
     * @return ActiveQuery|TariffQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariff::class, ['id' => 'tariff_id']);
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
     * @return static|null
     */
    public static function getLast(): ?self
    {
        return static::find()->last()->one();
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
