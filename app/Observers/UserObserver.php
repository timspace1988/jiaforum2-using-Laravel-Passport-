<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user){
        //Only when user has no avatar(e.g. New registered user), we give it a default avatar
        if(empty($user->avatar)){
            $user->avatar = 'https://jiaforum.s3.us-east-2.amazonaws.com/upload/images/avatars/default_avatar.jpg';
        }
    }
}
