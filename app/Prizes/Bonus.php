<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;

use App\Models\User;

/**
 * Class Bonus
 * @package App\Prizes
 *
 * @property int $amount
 * @property User $user
 */
class Bonus extends PrizeAmountable
{
    public function giveUser(): bool
    {
        
    }
}