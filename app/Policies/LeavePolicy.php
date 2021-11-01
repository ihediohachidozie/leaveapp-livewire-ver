<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Leave;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeavePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Leave $leave)
    {
        return $user->role_id == Role::IS_SUPERUSER ? Response::allow() : Response::deny('You are not a super user');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Leave $leave)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Leave $leave)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Leave $leave)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Leave $leave)
    {
        //
    }
}
