<?php

namespace App\Actions\Users;

use App\Models\User;

class GetAll
{
    public static function execute()
    {
        return User::getAll();
    }
}
