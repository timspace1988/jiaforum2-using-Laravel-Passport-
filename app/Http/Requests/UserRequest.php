<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),//'unique:users, name, except_id' is to check if the name is taken by other users except himself, we need this except_id for the case user still use the same name. if the id column is not called 'id', like 'user_id', you should put its column name at last, eg. unique:users, name, 1, user_id, this will except the user whose user id is 1
            'email' => 'required|email',
            'introduction' => 'max:80',
        ];
    }
}
