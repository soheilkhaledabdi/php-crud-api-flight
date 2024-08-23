<?php

namespace App\Actions\Users;

use App\Models\User;

class Create
{
    public static function execute()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data && isset($data['name'])) {
            $user = new User(null, $data['name']);
            $user->save();
            return ["message" => 'User created', "status" => true];
        } else {
            return ["message" => 'Invalid input', "status" => false];
        }
    }
}
