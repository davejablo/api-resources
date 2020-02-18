<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'products' => ProductResource::collection($this->products),
            'created_at' => date('d M Y H:i', strtotime($this->created_at)),
            'updated_at' => date('d M Y H:i', strtotime($this->updated_at)),
        ];
    }

//    /**
//     * Customize the outgoing response for the resource.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Illuminate\Http\Response  $response
//     * @return void
//     */
//    public function withResponse($request, $response)
//    {
//        $response->header('Random Value', 'True');
//    }
}
