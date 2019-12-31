<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * The code in before method will be executed before all policies we defined in other places
        If return true, user will get the given permisson, other policies will not be executed
        if return false, user will not get the permission, other polices will not be executed
        if return null, other policies will be executed and decide if give permision to user
     */
    public function before($user, $ability)
	{
	    // if ($user->isSuperAdmin()) {
	    // 		return true;
	    // }

        if($user->can('manage_contents')){
            return true;
        }
	}
}
