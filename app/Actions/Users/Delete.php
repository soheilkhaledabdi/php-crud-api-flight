<?php

namespace App\Actions\Users;

use App\Models\User;
use Exception;

class Delete
{
    public static function execute($id)
    {
        try {
            User::delete($id);
            return ['message' => getMessage('users_deleted'), 'status' => true];
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
