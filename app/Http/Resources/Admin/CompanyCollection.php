<?php

namespace App\Http\Resources\Admin;

use App\Helpers\DateTimeHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
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
                'created_at' => DateTimeHelper::getDateTime($item->created_at),
            ];
        }
        return $data;
    }
}
