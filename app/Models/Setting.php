<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    public const BALANCE_SETTING_NAME = 'balance';
    public const MAX_BONUS_PRIZE_AMOUNT_SETTING_NAME = 'max_bonus_prize_amount';
    public const MAX_CASH_PRIZE_AMOUNT_SETTING_NAME = 'max_cash_prize_amount';

    private function getSetting(string $settingName)
    {
        return self::where('name', '=', $settingName)->first()->value;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->getSetting(self::BALANCE_SETTING_NAME);
    }

    /**
     * @return int
     */
    public function getMaxBonusPrizeAmount(): int
    {
        return $this->getSetting(self::MAX_BONUS_PRIZE_AMOUNT_SETTING_NAME);
    }

    /**
     * @return int
     */
    public function getMaxCashPrizeAmount(): int
    {
        return $this->getSetting(self::MAX_CASH_PRIZE_AMOUNT_SETTING_NAME);
    }
}
