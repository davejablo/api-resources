<?php

namespace App\Http\Requests;

use App\Group;
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
                'group_id' => Rule::in(Group::all()->pluck('id')),
                'user_id' => [
                    Rule::in(User::all()->pluck('id')),
                    'integer'
                ],
                'name' => 'required|string|min:2|max:50',
                'description' => 'string|min:10|max:255|nullable',
                'expire_date' => 'required|date|after_or_equal:today',
                'cost' => 'nullable',
                'status' => Rule::in(Task::TASK_STATUS[1]),
            ];
        }
        elseif (!$this->request->has('user_id')){
            return [
                'group_id' => Rule::in(Group::all()->pluck('id')),
                'user_id' => 'nullable',
                'name' => 'required|string|min:2|max:50',
                'description' => 'string|min:10|max:255|nullable',
                'expire_date' => 'required|date|after_or_equal:today',
                'cost' => 'nullable',
                'status' => Rule::in(Task::TASK_STATUS[0]),
            ];
        }
    }
}
