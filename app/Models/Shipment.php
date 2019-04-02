<?php

namespace App\Models;

use App\Prizes\Prize;

/**
 * Class Shipment
 *
 * @package App\Models
 *
 * @property-read integer id
 * @property-read User    user
 * @property integer      user_id
 * @property string       name
 * @property string       status
 */
class Shipment extends PrizeAbstractModel
{
    public const AVAILABLE_STATUSES
        = [
            Prize::PRIZE_STATUS_FREE,
            Prize::PRIZE_STATUS_SUGGESTED,
            Prize::PRIZE_STATUS_ACCEPTED,
            Prize::PRIZE_STATUS_CANCELLED,
            Prize::PRIZE_STATUS_SENT,
        ];
}
