<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    protected function responseErrorCode($code)
    {
        $codes = [400, 401, 402, 404];
        return in_array($code, $codes) ? $code : 400;
    }

    protected function responseError($message, $code = 400)
    {
        return response()->json([
            'error' => $message],
            $code
        );
    }
}
