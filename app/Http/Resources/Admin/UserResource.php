<?php

namespace App\Http\Resources\Admin;

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
            'id' =>  $this->uuid,
            'first_name' =>  $this->first_name,
            'last_name' =>  $this->last_name,
            'email' =>  $this->email,
            'company_id' =>  $this->company->uuid ?? "",
            'image' => $this->image_path,
            'user_type' => $this->user_type,
            'town' => $this->town,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_date
        ];
    }
}
