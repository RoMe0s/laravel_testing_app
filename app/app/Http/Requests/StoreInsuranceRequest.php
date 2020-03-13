<?php

namespace App\Http\Requests;

use App\Models\ReferenceValue;
use App\Services\Insurance\StoreInsuranceDTO;
use Carbon\Carbon;

class StoreInsuranceRequest extends AuthFormRequest
{
    public function rules(): array
    {
        return [
            'case' => 'required|string|max:255',
            'mileage' => 'required|numeric|min:0|max:100000',
            'bought_at' => 'required|date|before_or_equal:' . Carbon::now(),
            'picture' => 'nullable|string',
            'reference_values' => 'array',
            'reference_values.*' => 'exists:reference_values,id',
        ];
    }

    public function attributes()
    {
        $attributes = [
            'case' => 'case',
            'mileage' => 'Mileage',
            'bought_at' => 'Bought at',
            'picture' => 'Picture',
        ];

        $referenceValues = ReferenceValue::query()->with('reference')->get();

        /** @var ReferenceValue $referenceValue */
        foreach ($referenceValues as $referenceValue) {
            $attributes['reference_values.' . $referenceValue->id] = $referenceValue->reference->name;
        }

        return $attributes;
    }

    public function messages()
    {
        return [
            'mileage.max' => 'We can\'t insure your car.',
        ];
    }

    public function getDTO(): StoreInsuranceDTO
    {
        return new StoreInsuranceDTO(
            $this->user()->id,
            $this->get('case'),
            $this->get('mileage'),
            $this->get('bought_at'),
            $this->get('picture'),
            $this->get('reference_values', []),
        );
    }
}
