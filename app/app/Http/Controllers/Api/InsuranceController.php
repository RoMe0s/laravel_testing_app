<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreInsuranceRequest;
use App\Services\Insurance\InsuranceService;
use Illuminate\Http\JsonResponse;

class InsuranceController extends ApiController
{
    public function store(StoreInsuranceRequest $request, InsuranceService $service): JsonResponse
    {
        $service->store($request->getDTO());

        return new JsonResponse();
    }
}
