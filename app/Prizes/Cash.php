<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;


use App\Models\Setting;
use App\Models\User;

/**
 * Class Cash
 * @package App\Prizes
 *
 * @property User $user
 * @property int $amount
 */
class Cash extends PrizeAmountable implements PrizeInterface, PrizeCountableInterface
{
    /** @var int $amount */
    private $amount;

    /**
     * Cash constructor.
     * @param int $amount
     * @param User $user
     */
    public function __construct(int $amount, User $user)
    {
        $this->amount = $amount;
        $this->user = $user;
    }


    public function count(): int
    {
        return Setting::where('name', '=', Setting::BALANCE_SETTING_NAME)->first()->value;
    }

    public function giveUser(): bool
    {

    }


}