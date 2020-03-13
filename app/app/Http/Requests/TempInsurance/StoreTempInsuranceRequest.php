<?php

namespace App\Http\Requests\TempInsurance;

use App\Http\Requests\AuthFormRequest;
use App\Models\ReferenceValue;
use App\Services\TempInsurance\SaveTempInsuranceDTO;
use Carbon\Carbon;

class StoreTempInsuranceRequest extends AuthFormRequest
{
    public function rules(): array
    {
        return [
            'case' => 'nullable|string|max:255',
            'mileage' => 'nullable|numeric|min:0',
            'bought_at' => 'nullable|date|before_or_equal:' . Carbon::now(),
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
        ];

        $referenceValues = ReferenceValue::query()->with('reference')->get();

        /** @var ReferenceValue $referenceValue */
        foreach ($referenceValues as $referenceValue) {
            $attributes['reference_values.' . $referenceValue->id] = $referenceValue->reference->name;
        }

        return $attributes;
    }

    public function getDTO(): SaveTempInsuranceDTO
    {
        return new SaveTempInsuranceDTO(
            $this->user()->id,
            $this->get('case'),
            $this->get('mileage'),
            $this->get('bought_at'),
            $this->get('reference_values', []),
        );
    }
}
