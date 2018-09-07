<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;

interface PrizeInterface
{
    public function giveUser(): bool;
}