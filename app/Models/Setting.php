<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public const BALANCE_SETTING_NAME = 'balance';
    public const MAX_BONUS_PRIZE_AMOUNT_SETTING_NAME = 'max_bonus_prize_amount';
    public const MAX_CASH_PRIZE_AMOUNT_SETTING_NAME = 'max_cash_prize_amount';
    public const CASH_TO_BONUSES_MULTIPLIER_SETTING_NAME = 'cash_to_bonuses_multiplier';
    public $timestamps = false;

    /**
     * @param int $amount
     */
    public function modifyBalance(int $amount): void
    {
        $balance = $this->getSetting(self::BALANCE_SETTING_NAME);
        $balance->value += $amount;
        if ($balance->value < 0) {
            throw new \InvalidArgumentException('Balance amount can\'t be < 0');
        }

        $balance->save();
    }

    /**
     * @param string $settingName
     *
     * @return mixed
     */
    private function getSetting(string $settingName)
    {
        return self::where('name', '=', $settingName)->first();
    }

    /**
     * @return int
     */
    public function getBalance(): Setting
    {
        return $this->getSetting(self::BALANCE_SETTING_NAME);
    }

    /**
     * @return int
     */
    public function getMaxBonusPrizeAmount(): int
    {
        return $this->getSettingValue(self::MAX_BONUS_PRIZE_AMOUNT_SETTING_NAME);
    }

    /**
     * @param string $settingName
     *
     * @return mixed
     */
    public function getSettingValue(string $settingName)
    {
        return $this->getSetting($settingName)->value;
    }

    /**
     * @return int
     */
    public function getMaxCashPrizeAmount(): int
    {
        return $this->getSettingValue(self::MAX_CASH_PRIZE_AMOUNT_SETTING_NAME);
    }
}
