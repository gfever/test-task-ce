<?php

namespace App\Policies;

use App\Models\User;
use App\Prizes\PrizeInterface;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrizePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User  $user
     * @param  PrizeInterface  $prize
     * @return bool
     */
    public function update(User $user, PrizeInterface $prize)
    {
        return $user->id === $prize->user_id;
    }
}
