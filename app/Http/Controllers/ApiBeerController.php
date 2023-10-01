<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Http\Requests\ApiBeerRequest;
use App\Library\JsonResponseData;
use App\Library\Message;
use App\Page;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Log;

class ApiBeerController extends Controller
{
    public function getList(Request $request): JsonResponse {
        $beer = new Beer();
        $query = $beer->newQuery();

        return $beer->getResponse($request, $query);
    }

    public function postBeer(ApiBeerRequest $request): JsonResponse {
        $beer = new Beer($request->all());
        $beer->user_id = \Auth::user()->id;

        try {
            $beer->save();
        } catch (Exception $exception) {
            Log::error($exception);

            return response()->json(JsonResponseData::formatData(
                $request,
                'There was a problem saving your beer',
                Message::MESSAGE_ERROR,
                [],
            ), 500);
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            'Beer saved successfully',
            Message::MESSAGE_OK,
            ['beer' => $beer],
        ));
    }

    public function getBeer(Request $request, $id): JsonResponse {
        $beer = Beer::find($id);

        if ($beer) {
            $user = null;

            try {
                $user = JWTAuth::parseToken()->toUser();
            } catch (Exception $exception) {
                Log::warning($exception);
            }

            if (($user && $user->id === $beer->user_id)) {
                return response()->json(JsonResponseData::formatData(
                    $request,
                    '',
                    Message::MESSAGE_OK,
                    ['beer' => $beer],
                ));
            }

            return response()->json(JsonResponseData::formatData(
                $request,
                'You are not authorized to view this beer',
                Message::MESSAGE_WARNING,
                [],
            ), 401);
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            'Beer not found',
            Message::MESSAGE_WARNING,
            [],
        ), 404);
    }

    public function updateBeer(ApiBeerRequest $request, $id): JsonResponse {
        $beer = Beer::find($id);

        if ($beer) {
            if ($beer->user_id === \Auth::user()->id) {
                $beer->fill($request->except('is_expanded'));
                try {
                    $beer->save();
                } catch (Exception $exception) {
                    Log::error($exception);

                    return response()->json(JsonResponseData::formatData(
                        $request,
                        'There was a problem updating your beer',
                        Message::MESSAGE_ERROR,
                        [],
                    ), 500);
                }

                return response()->json(JsonResponseData::formatData(
                    $request,
                    'Beer Updated',
                    Message::MESSAGE_SUCCESS,
                    ['beer' => $beer],
                ));
            }

            return response()->json(JsonResponseData::formatData(
                $request,
                'This is not your beer',
                Message::MESSAGE_WARNING,
                [],
            ), 401);
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            'Beer not found',
            Message::MESSAGE_WARNING,
            [],
        ), 404);
    }

    public function deleteBeer(Request $request, $id): JsonResponse {
        $beer = Beer::find($id);

        if ($beer) {
            if ($beer->user_id === \Auth::user()->id) {
                try {
                    $beer->delete();
                } catch (Exception $exception) {
                    Log::error($exception);

                    return response()->json(JsonResponseData::formatData(
                        $request,
                        'There was a problem deleting your beer',
                        Message::MESSAGE_ERROR,
                        [],
                    ), 500);
                }

                return response()->json(JsonResponseData::formatData(
                    $request,
                    'Beer Deleted',
                    Message::MESSAGE_SUCCESS,
                    [],
                ));
            }

            return response()->json(JsonResponseData::formatData(
                $request,
                'This is not your beer',
                Message::MESSAGE_WARNING,
                [],
            ), 401);
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            'Beer not found',
            Message::MESSAGE_WARNING,
            [],
        ), 404);
    }

    public function getStyles(Request $request): JsonResponse {
        return response()->json(JsonResponseData::formatData(
            $request,
            '',
            Message::MESSAGE_OK,
            ['styles' => Beer::STYLES],
        ));
    }

    public function getHomePage(Request $request): JsonResponse {
        $page = Page::query()
            ->where([
                ['app', Page::APP_BEER],
                ['page', Page::PAGE_TYPE_HOME],
            ])
            ->first();

        return response()->json(JsonResponseData::formatData(
            $request,
            'Page Found',
            Message::MESSAGE_OK,
            ['page' => $page],
        ));
    }
}
