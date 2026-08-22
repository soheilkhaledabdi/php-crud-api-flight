<?php

namespace App\Actions\Users;

use App\Models\User;

class Update
{
    public static function execute(int $id, array $data): array
    {
        $user = new User(id: $id, name: $data['name'], email: $data['email']);
        $user->update();

        return ['message' => getMessage('users_updated'), 'status' => true];
    }
}
