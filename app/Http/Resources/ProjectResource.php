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
        if ($request->query())
        return [

            'id' => $this->id,
            'name' => $this->name,
            'budget' => $this->budget,
            'report' => [
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'tasks_cost' => $this->getTasksCost($request),
                'total_tasks' => $this->getAmountOfAllTasks($request),
                'done_tasks' => $this->getAmountOfDoneTasks($request),
                'in_progress_tasks' => $this->getAmountOfInProgressTasks($request),
                'not_assigned_tasks' => $this->getAmountOfNaTasks($request),
                'assignees' => $this->getAmountOfAssignedUsers($request),
            ],
            'client' => $this->getClient(),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
        else
            return [
                'id' => $this->id,
                'name' => $this->name,
                'budget' => $this->budget,
                'tasks_cost' => $this->getTasksCost($request),
                'total_tasks' => $this->getAmountOfAllTasks($request),
                'done_tasks' => $this->getAmountOfDoneTasks($request),
                'in_progress_tasks' => $this->getAmountOfInProgressTasks($request),
                'not_assigned_tasks' => $this->getAmountOfNaTasks($request),
                'assignees' => $this->getAmountOfAssignedUsers($request),
                'client' => $this->getClient(),
                'users' => UserResource::collection($this->whenLoaded('users')),
                'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            ];
    }
}