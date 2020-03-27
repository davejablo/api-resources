<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'budget' => $this->budget,
            'tasks_cost' => $this->getTasksCost(),
            'total_tasks' => $this->getAmountOfAllTasks(),
            'done_tasks' => $this->getAmountOfDoneTasks(),
            'in_progress_tasks' => $this->getAmountOfInProgressTasks(),
            'not_assigned_tasks' => $this->getAmountOfNaTasks(),
            'assignees' => $this->getAmountOfAssignedUsers(),
            'client' => $this->getClient(),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}