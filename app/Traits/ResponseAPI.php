<?php

namespace App\Traits;

trait ResponseAPI
{
    public function coreResponse($message = null, $data = null, $statusCode, $isSuccess = true)
    {
        if ($isSuccess) {
            return response()->json([
                'error' => false,
                'results' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'error' => true,
                'message' => $message
            ], $statusCode);
        }
    }

    public function success($data, $statusCode = 200)
    {
        return $this->coreResponse(null, $data, $statusCode);
    }

    public function error($message, $statusCode = 500)
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }
}
