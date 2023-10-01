<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use App\Library\JsonResponseData;
use App\Library\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class ApiTestController extends Controller
{
    public function getHealthCheck(Request $request): JsonResponse {
        $message_type = Message::MESSAGE_ERROR;

        try {
            $db_check = HealthCheck::first();
        } catch (Exception $exception) {
            $message = 'Problem Retrieving from DB';
            Log::error($exception);

            return response()->json(JsonResponseData::formatData(
                $request,
                $message,
                $message_type,
                [
                    'api_checks' => '?',
                ]
            ));
        }

        $db_check->api_checks++;

        if ($db_check->save()) {
            $message = config('app.name') . ' Is Up and Running';
            $message_type = Message::MESSAGE_OK;
        } else {
            $message = 'Problem Saving to DB';
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            $message,
            $message_type,
            [
                'api_checks' => $db_check ? $db_check->api_checks : '?',
            ]
        ));
    }

    public function echo(Request $request): JsonResponse {
        return response()->json(JsonResponseData::formatData(
            $request,
            'Is there an echo in here?',
            Message::MESSAGE_OK,
            $request->input(),
        ));
    }
}
