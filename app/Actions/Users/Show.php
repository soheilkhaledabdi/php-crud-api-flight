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
                return ['message' => getMessage('users_found'), 'status' => true, 'data' => $user];
            else
                return ['message' => getMessage('users_not_found'), 'status' => false];
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage(), 'status' => false];
        }
    }
}
