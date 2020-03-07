<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function before(Admin $user, $ability){
        if($user->fullPermission()){
            return true;
        }
    }
    /**
     * Determine whether the user can view any roles.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Models\Admin  $user
     * @param  Role  $role
     * @return mixed
     */
    public function view(Admin $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\Admin  $user
     * @param  Role  $role
     * @return mixed
     */
    public function update(Admin $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\Admin  $user
     * @param  Role  $role
     * @return mixed
     */
    public function delete(Admin $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\Models\Admin  $user
     * @param  Role  $role
     * @return mixed
     */
    public function restore(Admin $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\Models\Admin  $user
     * @param  Role  $role
     * @return mixed
     */
    public function forceDelete(Admin $user, Role $role)
    {
        //
    }
}
