<?php

namespace App\Policies\Admin;

use App\Models\Comment;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function before(Admin $user, $ability){
        if ($user->fullPermission() || $user->hasAccess(['comments.*'])){
            return true;
        }
    }
    /**
     * Determine whether the user can view any comments.
     *
     * @param  Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return $user->hasAccess(['comments.viewAny']);
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param  Admin  $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function view(Admin $user, Comment $comment)
    {
        return $user->hasAccess(['comments.view']);
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return $user->hasAccess(['comments.create']);
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  Admin  $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function update(Admin $user, Comment $comment)
    {
        return $user->hasAccess(['comments.update']);
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  Admin  $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function delete(Admin $user, Comment $comment)
    {
        return $user->hasAccess(['comments.delete']);
    }

    /**
     * Determine whether the user can restore the comment.
     *
     * @param  Admin  $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function restore(Admin $user, Comment $comment)
    {
        return $user->hasAccess(['comments.restore']);
    }

    /**
     * Determine whether the user can permanently delete the comment.
     *
     * @param  Admin  $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function forceDelete(Admin $user, Comment $comment)
    {
        return $user->hasAccess(['comments.forceDelete']);
    }
}
