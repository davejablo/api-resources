<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'age' => $this->getAge(),
            'all_tasks' => $this->getAmountOfRelatedTasks(),
            'done_tasks' => $this->getAmountOfDoneTasks(),
            'in_progress_tasks' => $this->getAmountOfInProgressTasks(),
            'total_hours_spent' => $this->getHoursSpent(),
        ];
    }
}