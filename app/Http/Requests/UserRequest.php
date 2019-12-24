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
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
            //add some dimensions limit to image being uploaded.
            //actually mimes limit here is same with ext validation in ImageUploadHandler, but for secure reason, we still add it here.
        ];
    }

    //rewrite the messages() here, we can custom some error messages
    public function messages(){
        return [
            'avatar.mimes' =>'The avatar image extension must be jpeg, bmp, png, gif.',
            'avatar.dimensions' => 'The minimum image dimensions must be 208 x 208 px',
            // 'name.unique' => '用户名已被占用，请重新填写',
            // 'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            // 'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            // 'name.required' => '用户名不能为空。',
        ];
    }
}
