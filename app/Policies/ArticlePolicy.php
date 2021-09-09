<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view_articles');
    }

    /**
     * Determine whether the user can manage any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function manage(User $user){
        return $user->hasPermission('manage_articles');
    }
}
