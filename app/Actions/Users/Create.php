<?php

namespace App\Actions\Users;

use App\Models\User;
use Exception;

class Create
{
    public static function execute(array $data)
    {
        try {
            $user = new User(null, $data['name']);
            $user->save();
            return ["message" => getMessage('users_created'), "status" => true];
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
