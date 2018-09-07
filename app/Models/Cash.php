<?php

namespace App\Models;

use App\Prizes\PrizeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cash
 * @package App\Models
 *
 * @property int $amount
 * @property int $user_id
 * @property User $user
 * @property string $status
 */
class Cash extends Model implements PrizeInterface
{
    /**
     * @throws \Exception
     */
    public function setRandomAmount()
    {
        $balance = resolve(Setting::class)->getBalance();
        if ($balance < 1) {
            throw new \Exception('Empty balance');
        }

        $maxBonusPrizeAmount = resolve(Setting::class)->getMaxBonusPrizeAmount();
        $maxAmount =  $maxBonusPrizeAmount > $balance ? $balance : $maxBonusPrizeAmount;
        $this->amount = random_int(1, $maxAmount);
    }
}
