<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TempInsurance\{
    StoreTempInsuranceRequest,
    UploadTempInsurancePictureRequest,
};
use App\Http\Resources\TempInsuranceResource;
use App\Services\TempInsurance\TempInsuranceService;
use Illuminate\Http\Request;

class TempInsuranceController extends ApiController
{
    public function index(Request $request)
    {
        $tempInsurance = $request->user()->tempInsurance()->with('referenceValues.reference')->firstOrFail();

        return TempInsuranceResource::make($tempInsurance);
    }

    public function store(StoreTempInsuranceRequest $request, TempInsuranceService $service)
    {
        $tempInsurance = $service->save($request->getDTO())->load('referenceValues.reference');

        return TempInsuranceResource::make($tempInsurance);
    }

    public function updatePicture(UploadTempInsurancePictureRequest $request, TempInsuranceService $service)
    {
        $tempInsurance = $request->user()->tempInsurance()->firstOrFail();
        $updatedTempInsurance = $service->replacePicture($tempInsurance, $request->file('picture'));

        return TempInsuranceResource::make($updatedTempInsurance->load('referenceValues.reference'));
    }
}
