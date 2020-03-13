<?php

namespace App\Services\TempInsurance;

use App\Models\TempInsurance;
use App\Services\{ReferenceConfigurationService, FileService};
use Illuminate\Http\UploadedFile;

class TempInsuranceService
{
    private ReferenceConfigurationService $referenceConfigurationService;
    private FileService $fileService;

    public function __construct(ReferenceConfigurationService $referenceConfigurationService, FileService $fileService)
    {
        $this->referenceConfigurationService = $referenceConfigurationService;
        $this->fileService = $fileService;
    }

    public function save(SaveTempInsuranceDTO $saveDTO): TempInsurance
    {
        /** @var TempInsurance $tempInsurance */
        $tempInsurance = TempInsurance::query()->updateOrCreate(
            ['user_id' => $saveDTO->userId],
            [
                'case' => $saveDTO->case,
                'mileage' => $saveDTO->mileage,
                'bought_at' => $saveDTO->boughtAt,
            ]
        );

        $allAllowedReferenceValueIds = $this->referenceConfigurationService->getAllowedReferenceValueIds($saveDTO->referenceValueIds);
        $usedAllowedReferenceValueIds = array_intersect($allAllowedReferenceValueIds, $saveDTO->referenceValueIds);

        if ($usedAllowedReferenceValueIds) {
            $tempInsurance->referenceValues()->sync($usedAllowedReferenceValueIds);
        } else {
            $tempInsurance->referenceValues()->detach();
        }

        return $tempInsurance;
    }

    public function replacePicture(TempInsurance $tempInsurance, UploadedFile $file): TempInsurance
    {
        if ($existingPicture = $tempInsurance->picture) {
            $this->fileService->deleteFile($existingPicture);
        }

        $tempInsurance->picture = $this->fileService->saveFile($file);
        $tempInsurance->save();

        return $tempInsurance;
    }
}
