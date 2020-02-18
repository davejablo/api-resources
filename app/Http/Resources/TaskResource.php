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
            'family_id' => $this->family_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'descrption' => $this->description,
            'expire_date' => $this->expire_date,
            'cost' => $this->cost,
            'is_done' => $this->is_done,
        ];
    }
}
