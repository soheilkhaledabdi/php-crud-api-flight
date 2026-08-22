<?php

namespace App\Actions\Users;

use App\Models\User;

class Delete
{
    public static function execute(int $id): array
    {
        User::delete($id);

        return ['message' => getMessage('users_deleted'), 'status' => true];
    }
}
