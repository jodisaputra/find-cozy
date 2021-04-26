<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardingHouse extends JsonResource
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
            'user_id' => new User($this->user),
            'name' => $this->name,
            'address' => $this->address,
            'mapUrl' => $this->map_url,
            'city' => $this->city
        ];
    }
}
