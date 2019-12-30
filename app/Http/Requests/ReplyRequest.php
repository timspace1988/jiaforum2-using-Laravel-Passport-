<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    //Customize some error messages if you don't like the system default message
    public function messages()
    {
        return [
            'content.required' => 'The reply content can not be empty.',
            'content.min' => 'The minimum reply is 2 characters.',
        ];
    }
}
