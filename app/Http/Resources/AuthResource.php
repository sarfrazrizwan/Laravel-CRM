<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'company' =>  $this->company ? $this->company->title : "",
            'company_id' =>  $this->company? $this->company->uuid: "",
            'user_type' => $this->user_type,
            'town' => $this->town,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_date,
            'meta' => $this->meta,
            'access_token' => $this->getToken($request, $this),
        ];
    }
    private function getToken($request,$user)
    {
        $paths = ['api/login', 'api/register', 'admin/login'];
        $path = $request->path();
        $token = '';
        if (in_array($path, $paths))
        {
            $token = $user->createToken('Access Token')->plainTextToken;
        }
        return $token;
    }
}
