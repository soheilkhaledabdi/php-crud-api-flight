<?php

namespace App\Actions\Users;

use App\Models\User;

class Create
{
    public static function execute(array $data): array
    {
        $user = new User(name: $data['name'], email: $data['email']);
        $user->save();

        return ['message' => getMessage('users_created'), 'status' => true];
    }
}
