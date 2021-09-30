<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldResource extends JsonResource
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
            'placeholder' => $this->placeholder,
            'type' => $this->type,
            'options' => $this->options,
            'class' => $this->class,
            'validation' => $this->validation,
            'error_message' => $this->error_message,
            'tooltip' => $this->tooltip,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'value' => $this->value,
        ];
    }
}
