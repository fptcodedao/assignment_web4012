<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before(Admin $user, $ability){
        if($user->fullPermission()){
            return true;
        }
    }

    public function viewAny(Admin $user)
    {
        //
    }
    public function view(Admin $user, Admin $admin)
    {
        //
    }
    public function create(Admin $user)
    {
        //
    }

    public function update(Admin $user, Admin $admin)
    {
        //
    }

    public function delete(Admin $user, Admin $admin)
    {
        //
    }

    public function restore(Admin $user, Admin $admin)
    {
        //
    }

    public function forceDelete(Admin $user, Admin $admin)
    {
        //
    }
}
