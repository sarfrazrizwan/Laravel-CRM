<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResouce extends JsonResource
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
        'title' => $this->title,
        'type_value' => $this->type_value,
        'type' => $this->type,
        'fields' => $this->additional_fields,
        'project_status_id' => $this->status->uuid,
        'created_by' => $this->author->name,
        'status' => $this->status->title,
        'created_at' => $this->created_date,
        'comments' => ProjectCommentResource::collection($this->comments)
    ];
    }
}
