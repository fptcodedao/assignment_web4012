<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if($user->fullPermission() || $user->hasAccess(['users.*'])){
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        return $admin->hasAccess(['users.viewAny']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  User  $model
     * @return mixed
     */
    public function view(Admin $admin, User $model)
    {
        return $admin->hasAccess(['users.view']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasAccess(['users.create']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Admin  $admin
     * @param  User  $model
     * @return mixed
     */
    public function update(Admin $admin, User $model)
    {
        return $admin->hasAccess(['users.update']);

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Admin  $admin
     * @param  User  $model
     * @return mixed
     */
    public function delete(Admin $admin, User $model)
    {
        return $admin->hasAccess(['users.delete']);

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  Admin  $admin
     * @param User  $model
     * @return mixed
     */
    public function restore(Admin $admin, User $model)
    {
        return $admin->hasAccess(['users.restore']);

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  Admin  $admin
     * @param  User  $model
     * @return mixed
     */
    public function forceDelete(Admin $admin, User $model)
    {
        return $admin->hasAccess(['users.forceDelete']);

    }
}
