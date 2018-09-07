<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;

use App\Models\User;

/**
 * Class Shipment
 * @package App\Prizes
 *
 * @property \App\Models\Shipment $shipment
 * @property User $user
 */
class Shipment implements PrizeInterface, PrizeCountableInterface
{
    public function count()
    {
        return \App\Models\Shipment::count();
    }

    public function giveUser(): bool
    {

    }
}