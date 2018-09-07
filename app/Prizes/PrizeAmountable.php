<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;

/**
 * Class PrizeAmountable
 * @package App\Prizes
 *
 * @property int $amount
 */
abstract class PrizeAmountable extends Prize
{
    /** @var int $amount */
    private $amount;

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }


}