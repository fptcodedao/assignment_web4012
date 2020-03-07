<?php

namespace App\Policies\Admin;

use App\Models\Categories;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function before(Admin $user, $ability){
        if ($user->fullPermission() || $user->hasAccess(['category.*'])){
            return true;
        }
    }

    /**
     * Determine whether the user can view any categories.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return $user->hasAccess(['category.viewAny']);
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Categories  $category
     * @return mixed
     */
    public function view(Admin $user, Categories $category)
    {
        return $user->hasAccess(['category.view']);
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return $user->hasAccess(['category.create']);
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Categories  $category
     * @return mixed
     */
    public function update(Admin $user, Categories $category)
    {
        return $user->hasAccess(['category.update']);
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Categories  $category
     * @return mixed
     */
    public function delete(Admin $user, Categories $category)
    {
        return $user->hasAccess(['category.delete']);
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Categories  $category
     * @return mixed
     */
    public function restore(Admin $user, Categories $category)
    {
        return $user->hasAccess(['category.restore']);
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Categories  $category
     * @return mixed
     */
    public function forceDelete(Admin $user, Categories $category)
    {
        return $user->hasAccess(['category.forceDelete']);
    }
}
