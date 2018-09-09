<?php

namespace App\Models;

use App\Prizes\Prize;

/**
 * Class Bonus
 * @package App\Models
 *
 * @property int $amount
 * @property int $user_id
 * @property User $user
 * @property string $status
 */
class Bonus extends PrizeAbstractModel
{
    public const AVAILABLE_STATUSES = [
        Prize::PRIZE_STATUS_SUGGESTED,
        Prize::PRIZE_STATUS_ACCEPTED,
        Prize::PRIZE_STATUS_CANCELLED
    ];
    /**
     * @throws \Exception
     */
    public function setRandomAmount(): void
    {
        $this->amount = random_int(1, resolve(Setting::class)->getMaxBonusPrizeAmount());
    }

    /**
     * @param string $status
     */
    public function processStatus(string $status)
    {
        if ($status === Prize::PRIZE_STATUS_ACCEPTED) {
            \DB::transaction(function () {
                $this->user->bonuses += $this->amount;
                $this->user->save();
                $this->status = Prize::PRIZE_STATUS_ACCEPTED;
                $this->save();
            }, 5);
        } else {
            parent::processStatus($status);
        }
    }
}
