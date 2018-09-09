<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;


use App\Models\Cash;

class CashRepository extends Repository
{
    protected $model = Cash::class;
    protected $table = 'cashes';


}