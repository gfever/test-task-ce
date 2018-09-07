<?php
/**
 * @author d.ivaschenko
 */

namespace App\Prizes;


use App\Models\User;

abstract class Prize implements PrizeInterface
{
    /** @var User $user */
    private $user;

    public function setUser(User $user): void
    {
        $this->user = $user;
    }


}