<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use App\Models\Post;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if ($user->fullPermission() || $user->hasAccess(['posts.*'])){
            return true;
        }
    }


    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return $user->hasAccess(['posts.viewAny']);
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function view(Admin $user, Post $post)
    {
        $user->hasAccess(['posts.view']) || $user->id == $post->admin_id;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return $user->hasAccess(['posts.create']);
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function update($user, $post)
    {
//        dd($user->id , $post->admin_id);
        return $user->hasAccess(['posts.update']) || $user->id === $post->admin_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(Admin $user, Post $post)
    {
        $user->hasAccess(['posts.delete']) || $user->id === $post->admin_id;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function restore(Admin $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(Admin $user, Post $post)
    {
        //
    }
}
