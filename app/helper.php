<?php

use \Illuminate\Http\JsonResponse;

function success ($data = null, $status=200): JsonResponse {
    $result = ['status' => true];
    if ($data) {
        $result['result'] = $data;
    }
    return response()->json($result, $status);
}

