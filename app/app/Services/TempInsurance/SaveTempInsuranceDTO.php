<?php

namespace App\Services\TempInsurance;

class SaveTempInsuranceDTO
{
    public int $userId;
    public ?string $case;
    public ?float $mileage;
    public ?string $boughtAt;
    public array $referenceValueIds;

    public function __construct(int $userId, ?string $case, ?float $mileage, ?string $boughtAt, array $referenceValueIds)
    {
        $this->userId = $userId;
        $this->case = $case;
        $this->mileage = $mileage;
        $this->boughtAt = $boughtAt;
        $this->referenceValueIds = $referenceValueIds;
    }
}
