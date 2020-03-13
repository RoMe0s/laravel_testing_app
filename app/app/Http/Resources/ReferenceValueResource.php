<?php

namespace App\Http\Resources;

use App\Models\ReferenceValue;

/**
 * @mixin ReferenceValue
 */
class ReferenceValueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'reference' => $this->whenLoaded('reference', function () {
                return ReferenceResource::make($this->reference);
            }),
        ];
    }
}
