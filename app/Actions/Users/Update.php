<?php

namespace App\Actions\Users;

use App\Models\User;
use Exception;

class Update
{
    public static function execute($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = new User($id, $data['name']);
            $user->update();
            return ['message' => 'User successfully updated', 'status' => true];
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage(), 'status' => true];
        }
    }
}
