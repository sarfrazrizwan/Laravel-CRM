<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskStatusCollection extends ResourceCollection
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
                'id' => $item->uuid,
                'title' => $item->title,
                'created_at' => $item->created_date,
            ];
        }

        return $data;
    }
}
