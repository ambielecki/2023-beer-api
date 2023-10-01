<?php

namespace App\Http\Controllers;

use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiHomeController extends Controller
{
    public function getHome(Request $request): JsonResponse {
       return response()->json(JsonResponseData::formatData($request));
    }
}
