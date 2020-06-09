<?php

namespace App\Http\Requests\Task;

use App\Project;
use App\Task;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
        if ($this->request->has('user_id')){
            return [
                'project_id' => Rule::in(Project::all()->pluck('id')),
                'user_id' => [
                    Rule::in(User::all()->pluck('id')),
                    'integer'
                ],
                'name' => 'required|string|min:2|max:50',
                'description' => 'string|min:5|max:255|required',
                'expire_date' => 'required|date|after_or_equal:today',
                'hours_spent' => 'integer|min:1|max:24|nullable',
//                'status' => 'required', Rule::in(Task::TASK_STATUS[1]),
                'priority' => 'required', Rule::in(Task::TASK_PRIORITY),
            ];
        }
        elseif (!$this->request->has('user_id')){
            return [
                'project_id' => Rule::in(Project::all()->pluck('id')),
//                'user_id' => 'nullable',
                'name' => 'required|string|min:2|max:50',
                'description' => 'string|min:5|max:255|required',
                'expire_date' => 'required|date|after_or_equal:today',
                'status' => Rule::in(Task::TASK_STATUS[0]),
                'priority' => 'required', Rule::in(Task::TASK_PRIORITY),
            ];
        }
    }
}