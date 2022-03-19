<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends BaseApiController
{
    public function successResponse ($message, $redirectTo = null, $data = []): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (request()->wantsJson()) {
            return $this->success($message);
        }

        return $redirectTo
                ? redirect($redirectTo)->with('message', $message)
                : back()->with('message', $message);
    }

    /**
     * @throws Exception
     */
    public function failResponse ($statusCode, $message, $redirectTo = null, $data = []): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (request()->wantsJson()) {
            return $this->fail($statusCode, $message, $data);
        }

        return $redirectTo
                ? redirect($redirectTo)->with('error', $message)
                : redirect()->back()->with('error', $message);
    }

    /**
     * @throws Exception
     */
    public function unauthorized (): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->failResponse(403, "You don't have permission to change this resource");
    }

    /**
     * @throws Exception
     */
    public function internalError (): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->failResponse(500, "An internal error has occurred, inform the server admin.");
    }

    public function runOrFail (\Closure $callback, string $successMsg): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            DB::beginTransaction();

            $callback();

            DB::commit();
            return $this->successResponse($successMsg);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->internalError();
        }
    }
}
