<?php

namespace App\Controllers;

use App\Actions\Users\Create;
use App\Actions\Users\Delete;
use App\Actions\Users\GetAll;
use App\Actions\Users\Show;
use App\Actions\Users\Update;
use App\Traits\ApiResponse;

class UserController
{
    use ApiResponse;

    public function index()
    {
        return $this->success(GetAll::execute(), 'Users list route', 200);
    }

    public function store()
    {
        $result = Create::execute();
        if ($result['status'])
            return $this->success([], 'User create route');
        else
            return $this->failed([], 'User not created');
    }

    public function show($id)
    {
        $result = Show::execute($id);
        if ($result['status'])
            return $this->success($result['data'], $result['message']);
        else
            return $this->failed([], $result['message']);
    }

    public function update($id)
    {
        $result = Update::execute($id);
        if ($result['status'])
            return $this->success([], $result['message']);
        else
            return $this->failed([], $result['message']);
    }

    public function delete($id)
    {
        $result = Delete::execute($id);
        if ($result['status'])
            return $this->success([], $result['message']);
        else
            return $this->failed([], $result['message']);
    }
}
