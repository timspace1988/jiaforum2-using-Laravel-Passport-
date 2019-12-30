<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        //$user is the current logged-in user
        //Only Topic owner and reply owner can delete a reply
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
