<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FormFieldCollection extends ResourceCollection
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
    public function getData()
    {
        $data = [];
        foreach ($this->collection as $item) {
            $data[] = [
                'id' => $item->uuid,
                'name' => $item->name,
                'placeholder' => $item->placeholder,
                'type' => $item->type,
                'options' => $item->options,
                'class' => $item->class,
                'validation' => $item->validation,
                'error_message' => $item->error_message,
                'tooltip' => $item->tooltip,
                'sort_order' => $item->sort_order,
            ];
        }
        return $data;
    }
}
