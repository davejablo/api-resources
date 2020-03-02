<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'group_id' => 'integer|nullable',
            'user_id' => 'integer|nullable',
            'name' => 'string|min:2|max:50',
            'description' => 'string|min:10|max:255|nullable',
            'expire_date' => 'date|after_or_equal:today',
            'cost' => 'nullable',
            'status' => Rule::in(Task::TASK_STATUS),
            'is_done' => 'boolean'
        ];
    }
}