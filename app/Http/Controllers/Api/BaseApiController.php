<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    public function returnJson ($statusCode, $message, $data = []): \Illuminate\Http\JsonResponse {
        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function success ($message, $data = []): \Illuminate\Http\JsonResponse {
        return $this->returnJson(200, $message, $data);
    }

    /**
     * @throws Exception
     */
    public function fail ($statusCode, $message, $data = []): \Illuminate\Http\JsonResponse {
        if ($statusCode == 200) {
            throw new Exception(self::class . '::fail() method was called to return 200 status');
        }

        return $this->returnJson($statusCode, $message, $data);
    }
}
