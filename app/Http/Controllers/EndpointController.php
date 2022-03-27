<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirstEndpointRequest;
use App\Http\Requests\SecondEndpointRequest;
use App\Http\Requests\ThirdEndpointRequest;
use App\Models\EndpointData;
use Illuminate\Http\Request;

class EndpointController extends BaseController
{
    public function firstEndpoint (FirstEndpointRequest $req) {
        $validated = $req->validated();

        $newEndpointData = EndpointData::create([ 'data_json' => collect($validated)->toJson() ]);

        return $this->successResponse('data validated successfully.');
    }

    public function secondEndpoint (SecondEndpointRequest $req) {
        $validated = $req->validated();

        $newEndpointData = EndpointData::create([ 'data_json' => collect($validated)->toJson() ]);

        return $this->successResponse('data validated successfully.');
    }

    public function thirdEndpoint (ThirdEndpointRequest $req) {
        $validated = $req->validated();

        $newEndpointData = EndpointData::create([ 'data_json' => collect($validated)->toJson() ]);

        return $this->successResponse('data validated successfully.');
    }
}
