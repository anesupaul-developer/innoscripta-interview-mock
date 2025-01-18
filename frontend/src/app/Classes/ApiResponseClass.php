<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiResponseClass
{
    /**
     * @throws Throwable
     */
    public static function rollback($e, $message ="Something went wrong! Process not completed"): void
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message ="Something went wrong! Process not completed"){
        Log::info($e);
        throw new HttpResponseException(response()->json(["message"=> $message], 500));
    }

    public static function sendResponse($result , $message = null, $statusCode=200): JsonResponse
    {
        $response=[
            'data' => $result
        ];

        if (!empty($message)){
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }
}
