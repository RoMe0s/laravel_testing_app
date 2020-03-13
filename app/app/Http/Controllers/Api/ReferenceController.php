<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReferenceFilterRequest;
use App\Http\Resources\ReferenceResource;
use App\Services\ReferenceConfigurationService;

class ReferenceController extends ApiController
{
    public function index(ReferenceConfigurationService $service)
    {
        $globalReferences = $service->getConfiguration();

        return ReferenceResource::collection($globalReferences);
    }

    public function filter(ReferenceFilterRequest $request, ReferenceConfigurationService $service)
    {
        $allowedReferences = $service->getConfiguration($request->getReferenceValueIds());

        return ReferenceResource::collection($allowedReferences);
    }
}
