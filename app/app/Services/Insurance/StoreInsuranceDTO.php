<?php

namespace App\Services\Insurance;

class StoreInsuranceDTO
{
    public int $userId;
    public string $case;
    public float $mileage;
    public string $boughtAt;
    public ?string $picture;
    public array $referenceValueIds;

    public function __construct(
        int $userId,
        string $case,
        float $mileage,
        string $boughtAt,
        ?string $picture,
        array $referenceValueIds = []
    ) {
        $this->userId = $userId;
        $this->case = $case;
        $this->mileage = $mileage;
        $this->boughtAt = $boughtAt;
        $this->picture = $picture;
        $this->referenceValueIds = $referenceValueIds;
    }
}
