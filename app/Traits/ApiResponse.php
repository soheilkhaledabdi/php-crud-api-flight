<?php

namespace App\Traits;

use Flight;

trait ApiResponse
{
    public function success(array $data, string $message = 'Success', int $code = 200)
    {
        return Flight::json([
            'data' => $data,
            'status' => true,
            'message' => $message,
        ], $code);
    }

    public function failed(?array $data = null, string $message = 'Fail', int $code = 500)
    {
        return Flight::json([
            'data' => $data,
            'status' => false,
            'message' => $message,
        ], $code);
    }
}
