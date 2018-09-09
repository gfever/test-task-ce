<?php

namespace App\Models;

use App\Prizes\Prize;

/**
 * Class Cash
 * @package App\Models
 *
 * @property int $amount
 * @property int $user_id
 * @property User $user
 * @property string $status
 */
class Cash extends PrizeAbstractModel
{
    public const AVAILABLE_STATUSES = [
        Prize::PRIZE_STATUS_SUGGESTED,
        Prize::PRIZE_STATUS_ACCEPTED,
        Prize::PRIZE_STATUS_CANCELLED,
        Prize::PRIZE_STATUS_CONVERTED,
        Prize::PRIZE_STATUS_WITHDRAWAL
    ];

    /**
     * @throws \Exception
     */
    public function setRandomAmount(): void
    {
        $balance = resolve(Setting::class)->getBalance();
        if ($balance->value < 1) {
            throw new \Exception('Empty balance');
        }

        $maxBonusPrizeAmount = resolve(Setting::class)->getMaxBonusPrizeAmount();
        $maxAmount = $maxBonusPrizeAmount > $balance->value ? $balance->value : $maxBonusPrizeAmount;
        $this->amount = random_int(1, $maxAmount);
    }

    /**
     * @param string $status
     */
    public function processStatus(string $status)
    {
        if ($status === Prize::PRIZE_STATUS_CONVERTED) {
            \DB::transaction(function () {
                /** @var Setting $setting */
                $setting = resolve(Setting::class);
                $setting->modifyBalance($this->amount);
                $this->user->bonuses += $setting->getSettingValue(Setting::CASH_TO_BONUSES_MULTIPLIER_SETTING_NAME) * $this->amount;
                $this->user->save();
                $this->status = Prize::PRIZE_STATUS_CONVERTED;
                $this->save();
            }, 5);
        } else {
            parent::processStatus($status);
        }
    }
}
