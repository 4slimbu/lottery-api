<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;


class AttributeResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($attribute){
                return array( strtolower(str_replace(" ", "_",$attribute->name)) =>[
                    'id' => $attribute->id,
                    'options' => $attribute->core_attribute_options
                ]);
            }),
        ];
    }
}
