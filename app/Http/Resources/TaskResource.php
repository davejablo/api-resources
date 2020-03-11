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
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'expire_date' => $this->expire_date,
            'time_spent' => $this->time_spent,
            'task_cost' => $this->task_cost,
            'status' => $this->status,
            'is_done' => $this->is_done,
        ];
    }
}