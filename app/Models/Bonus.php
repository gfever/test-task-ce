<?php

namespace App\Models;

use App\Prizes\PrizeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bonus
 * @package App\Models
 *
 * @property int $amount
 * @property int $user_id
 * @property User $user
 * @property string $status
 */
class Bonus extends Model implements PrizeInterface
{
    /**
     * @throws \Exception
     */
    public function setRandomAmount()
    {
        $this->amount = random_int(1, resolve(Setting::class)->getMaxBonusPrizeAmount());
    }
}
