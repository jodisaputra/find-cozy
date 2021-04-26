<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardingRoom extends JsonResource
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
            'boarding_house_id' => $this->boarding_house_id,
            'name' => $this->name,
            'status' => $this->status,
            'price' => $this->price,
        ];
    }
}
