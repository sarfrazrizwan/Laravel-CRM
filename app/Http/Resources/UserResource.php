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
            'id' => $this->uuid,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'image' => $this->image_path,
            'email' =>  $this->email,
            'town' => $this->town,
            'postal_code' => $this->postal_code,
            'user_type' => $this->user_type,
            'created_at' => $this->created_date,
            'meta' => $this->meta,

        ];
    }

}
