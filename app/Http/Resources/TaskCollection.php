<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
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
                'users_count' => $item->users_count,
                'deadline' => $item->deadline ? $item->deadline->toDateTimeString() : null,
                'task_status_id' => $item->status->uuid,
                'project_id' => $item->project ? $item->project->uuid : null,
                'created_by' => $item->author->name,
                'status' => $item->status->title,
                'created_at' => $item->created_date,
                'fields' => $item->additional_fields,
            ];
        }
        return $data;
    }
}
