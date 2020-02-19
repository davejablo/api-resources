<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'family_id' => 'integer|nullable',
            'user_id' => 'integer|nullable',
            'name' => 'required|string|min:2|max:50',
            'description' => 'string|min:10|max:255|nullable',
            'expire_date' => 'required|dateTime|after_or_equal:today',
            'cost' => 'nullable',
            'is_done' => 'boolean'
        ];
    }
}
