<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * JSONレスポンスを日本語エスケープなしで返す共通メソッド
     * 
     * @param  mixed  $data
     * @param  int    $status
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($data, $status = 200): JsonResponse
    {
        return response()->json(
            $data,
            $status,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
