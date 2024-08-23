<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($data, $message = 'Success', $code = 200)
    {
        return $this->jsonResponse($data, true, $message, $code);
    }

    public function failed($data = null, $message = 'Fail', $code = 500)
    {
        return $this->jsonResponse($data, false, $message, $code);
    }

    private function jsonResponse($data, $status, $message, $code)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode([
            'result' => $data,
            'status' => $status,
            'message' => $message,
        ]);
    }
}
