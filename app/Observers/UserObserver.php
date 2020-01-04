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
            $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
    }
}
