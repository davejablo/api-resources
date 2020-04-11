<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'project' => new ProjectResource($this->project),
            'user' => new UserResource($this->user),
            'name' => $this->name,
            'description' => $this->description,
            'expire_date' => $this->expire_date,
            'hours_spent' => $this->hours_spent,
            'task_cost' => $this->task_cost,
            'status' => $this->status,
            'is_done' => $this->is_done,
            'priority' => $this->priority,
        ];
    }
}