<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp\Repositories;

use PrototypApp\Models\Bonus;

class BonusRepository extends Repository
{
    protected $model = Bonus::class;
    protected $table = 'bonuses';


}