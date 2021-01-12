<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ad extends JsonResource
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
            'user_id' => $this->user_id,
            'type_search_id' => $this->type_search_id,
            'number_animals' => $this->number_animals,
            'date' => $this->date,
            'departure_city' => $this->departure_city,
            'arrival_city' => $this->arrival_city,
            'description' => $this->description,
            'company' => $this->company,
            'image' => $this->image,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
