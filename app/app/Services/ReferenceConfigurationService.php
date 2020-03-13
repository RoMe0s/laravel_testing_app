<?php

namespace App\Services;

use App\Models\Reference;
use Illuminate\Support\Collection;

class ReferenceConfigurationService
{
    public function getConfiguration(array $referenceValueIds = []): Collection
    {
        $references = Reference::with(['values', 'dependOnValues'])->get();

        return $references->filter(function (Reference $reference) use ($referenceValueIds) {
            if ($reference->dependOnValues->isEmpty()) {
                return true;
            }

            $matchedReferenceValues = $reference->dependOnValues->whereIn('id', $referenceValueIds);
            return $matchedReferenceValues->count() === $reference->dependOnValues->count();
        });
    }

    public function getAllowedReferenceValueIds(array $referenceValueIds = []): array
    {
        $allowedReferences = $this->getConfiguration($referenceValueIds);

        return $allowedReferences->pluck('values')
            ->flatMap(fn(Collection $referenceValues) => $referenceValues->pluck('id'))
            ->intersect($referenceValueIds)
            ->toArray();
    }
}
