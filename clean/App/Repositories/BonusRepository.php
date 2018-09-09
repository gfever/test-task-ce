<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;

use App\Models\Bonus;

class BonusRepository extends Repository
{
    protected $model = Bonus::class;
    protected $table = 'bonuses';


}