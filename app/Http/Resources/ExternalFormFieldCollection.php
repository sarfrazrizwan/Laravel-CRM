<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExternalFormFieldCollection extends ResourceCollection
{

    public static $wrap = null;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->getData();
    }
    public function getData()
    {
        $data = [];
        foreach ($this->collection as $item) {
            $data[] = [
                'id' => $item->uuid,
                'name' => $item->name,
                'type' => $item->type,
                'class' => $item->class,
                'validation' => $item->validation,
                'errormessage' => $item->error_message,
                'tooltip' => $item->tooltip,
                'form_id' => $item->form->uuid,
                'created_at' => $item->created_at->format('Y-m-d H:m:s'),
                'updated_at' => $item->updated_at->format('Y-m-d H:m:s'),
                'placeholder' => $item->placeholder,
                'options' => $item->options,
                'sorting' => $item->sort_order,
                'status' => $item->status,
                'value' => $item->value,

            ];
        }

        return $data;
    }
}
