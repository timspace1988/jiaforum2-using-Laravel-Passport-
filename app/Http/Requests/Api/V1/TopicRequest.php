<?php

namespace App\Http\Requests\Api\V1;



class TopicRequest extends FormRequest
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
        return [
            'title' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function attributes(){
        return [
            'title' => 'topic title',
            'body' => 'topic content',
            'category_id' => 'category',
        ];
    }
}
