<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;


use App\Models\Bonus;
use App\Models\Cash;
use App\Models\User;

abstract class Prize implements PrizeInterface
{
    public const PRIZE_TYPE_BONUS = 'bonus';
    public const PRIZE_TYPE_CASH = 'cash';
    public const PRIZE_TYPE_SHIPMENT = 'shipment';
    public const PRIZE_TYPES = [self::PRIZE_TYPE_BONUS, self::PRIZE_TYPE_CASH, self::PRIZE_TYPE_SHIPMENT];

    public const PRIZE_STATUS_SUGGESTED = 'suggested';


    /** @var User $user */
    private $user;

    public function setUser(User $user): void
    {
        $this->user = $user;
    }



    /**
     * @return PrizeInterface
     * @throws \Exception
     */
    public function getRandomPrize(): PrizeInterface
    {
        $prizeTypes = self::PRIZE_TYPES;
        $prizeType = head(shuffle($prizeTypes));
        $prize = resolve(PrizeFabric::class)->getPrize($prizeType);

        if (\in_array($prizeType, [self::PRIZE_TYPE_BONUS, self::PRIZE_TYPE_CASH], true)) {
            /** @var Bonus|Cash $prize */
            $prize->setRandomAmount();
        }

        $prize->user_id = \Auth::id();
        $prize->status = self::PRIZE_STATUS_SUGGESTED;
        $prize->save();
        return $prize;
    }


}