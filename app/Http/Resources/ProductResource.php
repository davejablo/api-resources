<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'type' => $this->type,
            'details' => $this->details,
            'price' => $this->price,
            'created_at' => date('d M Y H:i', strtotime($this->created_at)),
            'updated_at' => date('d M Y H:i', strtotime($this->updated_at)),
        ];
    }
}
