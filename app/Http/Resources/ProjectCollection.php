<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['data' => $this->getData()];
    }
    private function getData()
    {
        $data = [];
        foreach ($this->collection as $item) {
            $data[] = [
                'id' => $item->uuid,
                'title' => $item->title,
                'type_value' => $item->type_value,
                'type' => $item->type,
                'fields' => $item->additional_fields,
                'users_count' => $item->users_count,
                'project_status_id' => $item->status->uuid,
                'created_by' => $item->author->name,
                'status' => $item->status->title,
                'created_at' => $item->created_date,

            ];
        }
        return $data;
    }
}
