<?php

namespace App\Services\Insurance;

use App\Events\InsuranceCreatedEvent;
use App\Models\Insurance;

class InsuranceService
{
    public function store(StoreInsuranceDTO $storeDTO): Insurance
    {
        /** @var Insurance $insurance */
        $insurance = Insurance::query()->create([
            'user_id' => $storeDTO->userId,
            'case' => $storeDTO->case,
            'mileage' => $storeDTO->mileage,
            'bought_at' => $storeDTO->boughtAt,
            'picture' => $storeDTO->picture,
        ]);

        $insurance->referenceValues()->sync($storeDTO->referenceValueIds);

        InsuranceCreatedEvent::dispatch($insurance);

        return $insurance;
    }
}
