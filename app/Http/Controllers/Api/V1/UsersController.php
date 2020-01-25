<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\Api\V1\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\V1\UserRequest;
use Illuminate\Auth\AuthenticationException;


class UsersController extends Controller
{
    public function store(UserRequest $request){
        //dd('Hello');
        $verifyData = \Cache::get($request->verification_key);

        if(!$verifyData){
            abort(403, 'Verification code has expired');
        }

        if(!hash_equals($verifyData['code'], $request->verification_code)){
            //return 401
            throw new AuthenticationException('Verification code is not right');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => $request->password,
        ]);

        //clear the verification info in cache
        \Cache::forget($request->verification_key);

        return new UserResource($user);
    }
}
