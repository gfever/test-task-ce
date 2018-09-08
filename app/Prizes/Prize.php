<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;


use App\Models\Bonus;
use App\Models\Cash;
use App\Models\Setting;
use App\Models\Shipment;

class Prize
{
    public const PRIZE_TYPE_BONUS = 'bonus';
    public const PRIZE_TYPE_CASH = 'cash';
    public const PRIZE_TYPE_SHIPMENT = 'shipment';
    public const PRIZE_TYPES = [
        self::PRIZE_TYPE_BONUS,
        self::PRIZE_TYPE_CASH,
        self::PRIZE_TYPE_SHIPMENT
    ];

    public const PRIZE_STATUS_FREE = 'free';
    public const PRIZE_STATUS_SUGGESTED = 'suggested';
    public const PRIZE_STATUS_ACCEPTED = 'accepted';
    public const PRIZE_STATUS_CANCELLED = 'cancelled';
    public const PRIZE_STATUS_CONVERTED = 'converted';
    public const PRIZE_STATUS_SENT = 'sent';


    private const MODELS_PACKAGE = '\App\Models';

    /**
     * @return array
     */
    public function getPrizesClasses(): array
    {
        return array_map(function ($value) {
           return self::MODELS_PACKAGE . '\\' . ucfirst($value);
        }, self::PRIZE_TYPES);
    }

    /**
     * @param string $type
     * @return PrizeInterface
     */
    public function getPrizeInstance(string $type): PrizeInterface
    {
        if (\in_array($type, self::PRIZE_TYPES, true)) {
            throw new \InvalidArgumentException("Unknown prize type: {$type}", 400);
        }

        return resolve( self::MODELS_PACKAGE . '\\' . ucfirst($type));
    }

    /**
     * @return PrizeInterface
     * @throws \Exception
     */
    public function getRandomPrize(): PrizeInterface
    {
        $prizeTypes = self::PRIZE_TYPES;
        shuffle($prizeTypes);
        $prizeType = head($prizeTypes);
        /** @var PrizeInterface $prize */
        $prize = $this->getPrizeInstance($prizeType);

        \DB::transaction(function () use ($prizeType, $prize) {
            if (\in_array($prizeType, [self::PRIZE_TYPE_BONUS, self::PRIZE_TYPE_CASH], true)) {
                /** @var Bonus|Cash $prize */
                $prize->setRandomAmount();
                if ($prizeType === self::PRIZE_TYPE_CASH) {
                    resolve(Setting::class)->modifyBalance($prize->amount);
                }
            }

            if ($prizeType === self::PRIZE_TYPE_SHIPMENT) {
                /** @var Shipment $prize */
                $prize = $prize->where('status', '=', self::PRIZE_STATUS_FREE)->orderBy(\DB::raw('RAND()'))->first();
            }

            $prize->user_id = \Auth::id();
            $prize->updateStatus(self::PRIZE_STATUS_SUGGESTED);
            $prize->save();
        }, 5);

        return $prize;
    }


}