<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->getData()
        ];
    }
    private function getData()
    {
        $data = [];
        foreach ($this->collection as $item) {
            $data[] = [
                'id' =>  $item->uuid,
                'first_name' =>  $item->first_name,
                'last_name' =>  $item->last_name,
                'email' =>  $item->email,
                'company' =>  $item->company ?$item->company->title :"",
                'image' => $item->image_path,
                'user_type' => $item->user_type,
                'town' => $item->town,
                'postal_code' => $item->postal_code,
                'created_at' => $item->created_date
            ];
        }

        return $data;
    }
}
