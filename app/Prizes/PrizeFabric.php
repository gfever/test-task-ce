<?php
/**
 * Created by PhpStorm.
 * User: fevr
 * Date: 08.09.2018
 * Time: 1:06
 */

namespace App\Prizes;


use App\Models\Bonus;
use App\Models\Cash;
use App\Models\Shipment;

/**
 * Class PrizeFabric
 * @package App\Prizes
 */
class PrizeFabric
{
    /**
     * @param string $type
     * @return PrizeInterface
     */
    public function getPrize(string $type): PrizeInterface
    {
        $prize = null;
        switch ($type) {
            case Prize::PRIZE_TYPE_BONUS:
                $prize = resolve(Bonus::class);
                break;
            case Prize::PRIZE_TYPE_CASH:
                $prize = resolve(Cash::class);
                break;
            case Prize::PRIZE_TYPE_SHIPMENT:
                $prize = resolve(Shipment::class)->whereStatus(Shipment::STATUS_FREE)->orderBy(\DB::raw('RAND()'))->first();
                break;
            default:
                throw new \InvalidArgumentException("Unknown prize type: {$type}");
        }

        return $prize;
    }
}