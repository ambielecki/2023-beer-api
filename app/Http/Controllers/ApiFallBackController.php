<?php

namespace App\Http\Controllers;

use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiFallBackController extends Controller
{
    public function getFallBack(Request $request): JsonResponse {
        return response()->json(JsonResponseData::formatData(
            $request,
            'Page Not Found',
            Message::MESSAGE_ERROR,
            []
        ), 404);
    }
}
