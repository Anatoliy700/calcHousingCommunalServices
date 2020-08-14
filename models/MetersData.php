<?php

namespace app\models;

use app\Exceptions\NotFoundPreviewMetersDataException;
use app\models\Query\MetersDataQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%meters_data}}".
 *
 * @property int $id
 * @property int $t1
 * @property int $t2
 * @property int $t3
 * @property int $col
 * @property int $hot
 * @property string $created_at
 * @property string $updated_at
 */
class MetersData extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%meters_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['t1', 't2', 't3', 'col', 'hot'], 'required'],
            [['t1', 't2', 't3', 'col', 'hot'], 'integer'],
            [['t1', 't2', 't3', 'col', 'hot'], 'actualValueValidator'],
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
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function actualValueValidator($attribute, $params): bool
    {
        static $prevModel = null;
        if (is_null($prevModel)) {
            $prevModel = $this->getPrevious();
        }

        if (!is_null($prevModel) && !($this->$attribute > $prevModel->$attribute)) {
            $this->addError($attribute, "Значение должно быть больше предыдущего ({$prevModel->$attribute})");
        }

        return !$this->hasErrors($attribute);
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MetersDataQuery the active query used by this AR class.
     */
    public static function find(): MetersDataQuery
    {
        return new MetersDataQuery(get_called_class());
    }

    /**
     * @return static|null
     */
    public static function getLast(): ?self
    {
       return $model = static::find()->last()->one();
    }

    /**
     * @return $this|null
     */
    public function getPrevious(): ?self
    {
        $query = static::find();

        if ($this->isNewRecord) {
            $query->last();
        } else {
            $query->previous($this->id);
        }

        return $model = $query->one();
    }
}
