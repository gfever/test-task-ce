<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp\Repositories;


use PrototypApp\Models\Cash;

class CashRepository extends Repository
{
    protected $model = Cash::class;
    protected $table = 'cashes';


}