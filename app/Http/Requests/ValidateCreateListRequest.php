<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCreateListRequest extends FormRequest
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

            'list_name' => 'bail|required',
            'list_description' => 'bail|required',
            'selected_tags' => 'bail|required|array',
            'product' => 'bail|required|array',

        ];
    }
}
