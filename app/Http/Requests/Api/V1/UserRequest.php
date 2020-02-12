<?php

namespace App\Http\Requests\Api\V1;

//use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST':
                return [
                    'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
                    'password' => 'required|alpha_dash|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                $userId = auth('api')->id();
                return [
                    //Name must be unique but except for current user(e.g. new name is same as old one)
                    'name' => 'between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' .$userId,
                    'email' => 'email|unique:users,email,' . $userId,
                    'introduction' => 'max:80',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
                ];
                break;

        }

    }

    //Customizing the name of validation attributes
    public function attributes(){
        return  [
            'verification_key' => 'Verification key',
            'verification_code' => 'Verification code',
        ];
    }

    public function messages(){
        return [
            'name.unique' => 'The name has beed used.',
            'name.regex' => 'The name can only include letter, number, - and _.',
            'name.between' => 'The length of name must be between 3 and 25',
            'name.required' => 'The name is required.',
        ];
    }
}
