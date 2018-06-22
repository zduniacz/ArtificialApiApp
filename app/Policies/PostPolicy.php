<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $user->isAuthor($post);
    }

    public function destroy(User $user, Post $post)
    {
        // TODO: include additional check isAdmin() after implementing user roles
        return $user->isAuthor($post);
    }

}
