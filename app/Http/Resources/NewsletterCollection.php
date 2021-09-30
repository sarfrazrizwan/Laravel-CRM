<?php

namespace App\Http\Resources;

use App\Helpers\DateTimeHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsletterCollection extends ResourceCollection
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
                'name' => $item->name,
                'subject' => $item->subject,
                'status' => $item->status_value,
                'recipients' => $item->user_types_value,
                'customer_groups' => $item->company_groups_value,
                'updated_at' => DateTimeHelper::getDateTime($item->updated_at),
            ];
        }
        return $data;
    }

}
