<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user){
        //UserRequest extends the 'FormRequest'
        //we will use 'FormRequest' to validate the data
        //we design the rules it in UserRequest class (created by us)
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', 'Your profiles has been updated');
    }
}
