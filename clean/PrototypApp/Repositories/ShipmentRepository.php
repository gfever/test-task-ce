<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp\Repositories;

use PrototypApp\Models\Shipment;

class ShipmentRepository extends Repository
{
    protected $model = Shipment::class;
    protected $table = 'shipments';


}