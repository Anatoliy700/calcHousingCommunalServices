<?php

namespace app\Services;

use app\models\CalcResult;
use yii\base\InvalidArgumentException;

class CalculateService
{
    /**
     * @var CalcResult
     */
    protected $calcResult;

    /**
     * CalculateService constructor.
     * @param CalcResult $calcResult
     * @throws \Exception
     */
    public function __construct(CalcResult $calcResult)
    {
        $this->calcResult = $calcResult;
        $this->init();
    }

    /**
     * @throws \Exception
     */
    protected function init(): void
    {
        if (!$this->calcResult->validate()) {
            $message = '';
            foreach ($this->calcResult->getFirstErrors() as $attrName => $firstErrorMessage) {
                $message .= $firstErrorMessage . PHP_EOL;
            }
            throw new \Exception($message);
        }
    }

    /**
     * @return int
     */
    public function getCurrentT1(): int
    {
        return $this->calcResult->currentMeters->t1;
    }

    /**
     * @return int
     */
    public function getCurrentT2(): int
    {
        return $this->calcResult->currentMeters->t2;
    }

    /**
     * @return int
     */
    public function getCurrentT3(): int
    {
        return $this->calcResult->currentMeters->t3;
    }

    /**
     * @return int
     */
    public function getCurrentCol(): int
    {
        return $this->calcResult->currentMeters->col;
    }

    /**
     * @return int
     */
    public function getCurrentHot(): int
    {
        return $this->calcResult->currentMeters->hot;
    }

    /**
     * @return int
     */
    public function getCurrentSewerage(): int
    {
        return $this->calcResult->currentMeters->hot + $this->calcResult->currentMeters->col;
    }

    /**
     * @return int
     */
    public function getPreviewT1(): int
    {
        return $this->calcResult->previousMeters->t1;
    }

    /**
     * @return int
     */
    public function getPreviewT2(): int
    {
        return $this->calcResult->previousMeters->t2;
    }

    /**
     * @return int
     */
    public function getPreviewT3(): int
    {
        return $this->calcResult->previousMeters->t3;
    }

    /**
     * @return int
     */
    public function getPreviewCol(): int
    {
        return $this->calcResult->previousMeters->col;
    }

    /**
     * @return int
     */
    public function getPreviewHot(): int
    {
        return $this->calcResult->previousMeters->hot;
    }

    /**
     * @return int
     */
    public function getPreviewSewerage(): int
    {
        return $this->calcResult->previousMeters->hot + $this->calcResult->previousMeters->col;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDiffT1(): int
    {
        return $this->getDiffMeters('t1');
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDiffT2(): int
    {
        return $this->getDiffMeters('t2');
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDiffT3(): int
    {
        return $this->getDiffMeters('t3');
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDiffCol(): int
    {
        return $this->getDiffMeters('col');
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDiffHot(): int
    {
        return $this->getDiffMeters('hot');
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDiffSewerage(): int
    {
        return $this->getDiffMeters('sewerage');
    }

    /**
     * @return float
     */
    public function getTariffT1(): float
    {
        return $this->calcResult->tariff->t1;
    }

    /**
     * @return float
     */
    public function getTariffT2(): float
    {
        return $this->calcResult->tariff->t2;
    }

    /**
     * @return float
     */
    public function getTariffT3(): float
    {
        return $this->calcResult->tariff->t3;
    }

    /**
     * @return float
     */
    public function getTariffTCol(): float
    {
        return $this->calcResult->tariff->col;
    }

    /**
     * @return float
     */
    public function getTariffHot(): float
    {
        return $this->calcResult->tariff->hot;
    }

    /**
     * @return float
     */
    public function getTariffSewerage(): float
    {
        return $this->calcResult->tariff->sewerage;
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostT1(): float
    {
        return $this->getCostDiffMeters('t1');
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostT2(): float
    {
        return $this->getCostDiffMeters('t2');
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostT3(): float
    {
        return $this->getCostDiffMeters('t3');
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostCol(): float
    {
        return $this->getCostDiffMeters('col');
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostHot(): float
    {
        return $this->getCostDiffMeters('hot');
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostSewerage(): float
    {
        return $this->getCostDiffMeters('sewerage');
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getCostTotal(): float
    {
        $total = 0;
        $attributes = ['t1', 't2', 't3', 'col', 'hot', 'sewerage'];

        foreach ($attributes as $attribute) {
            $total += $this->getCostDiffMeters($attribute);
        }

        return $total;
    }

    /**
     * @param string $attribute
     * @return float
     * @throws \Exception
     */
    protected function getCostDiffMeters(string $attribute): float
    {
        if (!$this->calcResult->tariff->hasAttribute($attribute)) {
            throw new InvalidArgumentException('Не найден атрибут \"{$attribute}\" в модели Tariffs');
        }
        $tariff = $this->calcResult->tariff->$attribute;
        $diff = $this->getDiffMeters($attribute);

        return $diff * $tariff;
    }

    /**
     * @param string $attribute
     * @return int
     * @throws \Exception
     */
    protected function getDiffMeters(string $attribute): int
    {
        $currentData = $this->calcResult->currentMeters;
        $previousData = $this->calcResult->previousMeters;

        if ($attribute === 'sewerage') {
            $diffCol = $this->getDiffMeters('col');
            $diffHot = $this->getDiffMeters('hot');
            $diff = $diffHot + $diffCol;
        } else {
            if (!$currentData->hasAttribute($attribute) || !$previousData->hasAttribute($attribute)) {
                throw new InvalidArgumentException("Не найден атрибут \"{$attribute}\" в модели MetersData");
            }

            if (($diff = $currentData->$attribute - $previousData->$attribute) <= 0) {
                throw new \Exception("Для аттрибута \"{$attribute}\" текущие данные должны быть больше предшествующих");
            }
        }

        return $diff;
    }
}
