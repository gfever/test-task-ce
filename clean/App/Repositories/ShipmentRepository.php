<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;

use App\Models\Shipment;

class ShipmentRepository extends Repository
{
    protected $model = Shipment::class;
    protected $table = 'shipments';


}