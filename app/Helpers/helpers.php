<?php

if (!function_exists('generateResponse')) {
    function generateResponse($message, $data = null, $status_code = 200, $status = 'success',)
    {
        return response()->json([
            'status_code' => $status_code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
