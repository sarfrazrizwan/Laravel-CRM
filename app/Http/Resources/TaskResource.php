<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'description' => $this->description,
            'deadline' => $this->deadline ? $this->deadline->toDateTimeString() : null,
            'task_status_id' => $this->status->uuid,
            'created_by' => $this->author->name,
            'status' => $this->status->title,
            'created_at' => $this->created_date,
            'project_id' => $this->project ? $this->project->uuid : null,
            'comments' => TaskCommentResource::collection($this->comments),
            'fields' => $this->additional_fields,
        ];
    }
}
