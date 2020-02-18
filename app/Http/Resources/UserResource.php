<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'family_id' => $this->family_id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => date('d M Y H:i', strtotime($this->created_at)),
            'updated_at' => date('d M Y H:i', strtotime($this->updated_at)),
        ];
//        return parent::toArray($request);
    }
}
