<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PostTag extends FormRequest
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
            'tags_name' => 'required'
        ];
    }

    public function formatErrors(Validator $validator)
    {
        return ['status' => 'ERROR', 'message' => 'incomplete request data', 'error' => 'incomplete request data', 'data' => $validator->errors()];
    }

    public function wantsJson()
    {
        return true;
    }
}
