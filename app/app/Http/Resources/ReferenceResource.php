<?php

namespace App\Http\Resources;

use App\Models\Reference;

/**
 * @mixin Reference
 */
class ReferenceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
            'values' => $this->whenLoaded('values', function () {
                return ReferenceValueResource::collection($this->values);
            }),
        ];
    }
}
