<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        //$user is the current user, which will be injected here by laravel
        return $user->isAuthorOf($topic);
        //return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        //$user is the current user, which will be injected here by laravel
        return $user->isAuthorOf($topic);
    }
}
