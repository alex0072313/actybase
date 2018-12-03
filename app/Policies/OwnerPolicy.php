<?php

namespace App\Policies;

use App\User;
use App\owner;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the owner.
     *
     * @param  \App\User  $user
     * @param  \App\owner  $owner
     * @return mixed
     */
    public function view(User $user, owner $owner)
    {
        //
    }

    /**
     * Determine whether the user can create owners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the owner.
     *
     * @param  \App\User  $user
     * @param  \App\owner  $owner
     * @return mixed
     */
    public function update(User $user, owner $owner)
    {
        //
    }

    /**
     * Determine whether the user can delete the owner.
     *
     * @param  \App\User  $user
     * @param  \App\owner  $owner
     * @return mixed
     */
    public function delete(User $user, owner $owner)
    {
        //
    }

    /**
     * Determine whether the user can restore the owner.
     *
     * @param  \App\User  $user
     * @param  \App\owner  $owner
     * @return mixed
     */
    public function restore(User $user, owner $owner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the owner.
     *
     * @param  \App\User  $user
     * @param  \App\owner  $owner
     * @return mixed
     */
    public function forceDelete(User $user, owner $owner)
    {
        //
    }
}
