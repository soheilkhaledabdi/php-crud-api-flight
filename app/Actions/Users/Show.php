<?php

namespace App\Actions\Users;

use App\Models\User;
use Exception;

class Show
{
    public static function execute($id)
    {
        try {
            $user = User::getById($id);
            if ($user !== false)
                return ['message' => "User successfully resulted", 'status' => true, 'data' => $user];
            else
                return ['message' => "User not found", 'status' => false];
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage(), 'status' => false];
        }
    }
}
