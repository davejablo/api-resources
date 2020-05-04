<?php

namespace App\Http\Requests\User;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'hr_wage' => 'nullable|numeric|between:12.00,90.00',
            'project_id' => 'nullable', Rule::in(Project::all()->pluck('id')),
        ];
    }
}