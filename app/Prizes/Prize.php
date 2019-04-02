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
    public const PRIZE_TYPES
        = [
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
    public const PRIZE_STATUS_WITHDRAWAL = 'withdrawal';


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
     * @return PrizeInterface
     * @throws \Exception
     */
    public function getRandomPrize(): PrizeInterface
    {
        $prizeType = $this->choosePrizeType();
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

            $prize->user_id = auth()->user()->id;
            $prize->updateStatus(self::PRIZE_STATUS_SUGGESTED);
            $prize->save();
        }, 5);

        if (empty($prize->id)) {
            throw new \Exception('Prize create failed');
        }

        return $prize;
    }

    /**
     * @return string
     */
    private function choosePrizeType(): string
    {
        $prizeChosen = false;
        $prizeType = self::PRIZE_TYPE_BONUS;
        while ($prizeChosen === false) {
            $prizeTypes = self::PRIZE_TYPES;
            shuffle($prizeTypes);
            $prizeType = head($prizeTypes);

            if ($prizeType === self::PRIZE_TYPE_SHIPMENT
                && empty(resolve(Shipment::class)->where('status', '=', self::PRIZE_STATUS_FREE)->first())
            ) {
                unset($prizeTypes[2]);
                continue;
            }

            if ($prizeType === self::PRIZE_TYPE_CASH && resolve(Setting::class)->getBalance()->value < 1) {
                unset($prizeTypes[1]);
                continue;
            }

            $prizeChosen = true;
        }

        return $prizeType;
    }

    /**
     * @param string $type
     *
     * @return PrizeInterface
     */
    public function getPrizeInstance(string $type): PrizeInterface
    {
        if (!\in_array($type, self::PRIZE_TYPES, true)) {
            throw new \InvalidArgumentException("Unknown prize type: {$type}", 400);
        }

        return resolve(self::MODELS_PACKAGE . '\\' . ucfirst($type));
    }


}