<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'status_code' => $code,
            'message' => $message,
            'data' => $result,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

    public function sendError($error): JsonResponse
    {
        $response = [
            'success' => false,
            'status_code' => 400,
            'message' => $error,
        ];

        return response()->json($response, 400);
    }
}
