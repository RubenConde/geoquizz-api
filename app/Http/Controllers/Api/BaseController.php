<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param string $type
     * @param int $code
     * @return Response
     */
    public function sendResponse($result, $message, $code = 200, $type = 'resource')
    {
        $response = [
            'success' => true,
            'type' => $type,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, $code, [
            'Content-Type' => 'application/json;charset=utf-8',
        ]);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [];

        $response = [
            'success' => false,
            'type' => 'error',
            'status' => $code,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code, [
            'Content-Type' => 'application/json;charset=utf-8',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
