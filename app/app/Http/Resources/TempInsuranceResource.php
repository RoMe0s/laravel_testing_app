<?php

namespace App\Http\Resources;

use App\Models\TempInsurance;

/**
 * @mixin TempInsurance
 */
class TempInsuranceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'case' => $this->case,
            'mileage' => $this->mileage,
            'bought_at' => $this->bought_at ? $this->bought_at->toDateString() : null,
            'picture' => $this->picture ? url($this->picture) : null,
            'reference_values' => $this->whenLoaded('referenceValues', function () {
                return ReferenceValueResource::collection($this->referenceValues);
            }),
        ];
    }
}
