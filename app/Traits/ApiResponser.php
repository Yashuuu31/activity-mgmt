<?php

namespace App\Traits;

trait ApiResponser
{
    public function apiSuccess($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    public function apiError($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
