<?php

namespace App\Actions\Users;

use App\Models\User;

class Show
{
    public static function execute(int $id): array
    {
        $user = User::getById($id);

        if ($user !== false) {
            return ['message' => getMessage('users_found'), 'status' => true, 'data' => $user];
        }

        return ['message' => getMessage('users_not_found'), 'status' => false];
    }
}
