<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($message, $statusCode = 200) {
        return response()->json(['status' => 'OK', 'message' => $message], $statusCode);
    }

    public function errorResponse($message, $errorCode = 500) {
        return response()->json(['status' => 'ERROR', 'message' => $message, 'error' => $message], $errorCode);
    }

    public function errorDataResponse($message, $errorCode, $errorArray) {
        return response()->json(['status' => 'ERROR', 'message' => $message, 'error' => $message, 'errorData' => $errorArray], $errorCode);
    }

    public function dataResponse($data, $message = "success") {
        return response()->json(['status' => 'OK', 'message' => $message, 'data' => $data]);
    }

    public function parseResponse($message) {
        preg_match('/{(.+?)}/', $message, $match);

        if (isset($match[0])) {
            return $match[0];
        }

        return null;
    }
}
