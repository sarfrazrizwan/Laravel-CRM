<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsletterResource extends JsonResource
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
            'subject' => $this->subject,
            'content' => $this->content,
            'user_types' => $this->user_types,
            'company_group_ids' => $this->company_group_ids,
        ];
    }
}
