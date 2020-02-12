<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\Api\V1\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\V1\UserRequest;
use Illuminate\Auth\AuthenticationException;
use App\Models\Image;


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

        //$user is a model, the instance of UserResoure will respresent it in json
        //and autometically call toArray method to return an array to client
        return (new UserResource($user))->showSensitiveFields();
    }

    public function show(User $user, Request $request){
        return new UserResource($user);
    }

    public function me(Request $request){
        return (new UserResource($request->user()))->showSensitiveFields();
        //If user has been verified by auth:api, we can get it using $request->user()
    }

    //Update user info
    public function update(UserRequest $request){
        $user = $request->user();
        $attributes = $request->only(['name', 'email', 'introduction']);

        if($request->avatar_image_id){
            $image = Image::find($request->avatar_image_id);
            $attributes['avatar'] = $image->path;
        }

        $user->update($attributes);
        return (new UserResource($user))->showSensitiveFields();
    }
}
