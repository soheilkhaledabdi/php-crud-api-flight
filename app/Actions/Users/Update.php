<?php

namespace App\Actions\Users;

use App\Models\User;
use Exception;

class Update
{
    public static function execute(int $id,array $data): array
    {
        try {
            $user = new User($id, $data['name']);
            $user->update();
            return ['message' => getMessage('users_updated'), 'status' => true];
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
