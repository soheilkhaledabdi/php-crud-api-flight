<?php

namespace App\Controllers;

use GeekGroveOfficial\PhpSmartValidator\Validator\Validator;
use App\Actions\Users\Create;
use App\Actions\Users\Delete;
use App\Actions\Users\GetAll;
use App\Actions\Users\Show;
use App\Actions\Users\Update;
use App\Traits\ApiResponse;
use Exception;
use Flight;

class UserController
{
    use ApiResponse;

    public function index()
    {
        return $this->success(GetAll::execute(), getMessage('users_route'), 200);
    }

    public function store()
    {
        $request = Flight::request()->data->getData();

        $validator = new Validator($request, [
            'name' => ['required', 'string'],
        ]);

        if (!$validator->validate())
            return $this->failed($validator->errors(), getMessage('invalid_input'), 400);

        try {
            $result = Create::execute($request);
            return $this->success([], $result['message'], 201);
        } catch (Exception $exception) {
            return $this->failed([], getMessage('users_not_created'));
        }
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
        $request = Flight::request()->data->getData();

        $validator = new Validator($request, [
            'name' => ['required', 'string'],
        ]);

        if (!$validator->validate())
        return $this->failed($validator->errors(), getMessage('invalid_input'), 400);

        try {
            $result = Update::execute($id, $request);
            return $this->success([], $result['message']);

        } catch (Exception $exception) {
            return $this->failed([], getMessage('users_not_updated'));
        }
    }

    public function delete($id)
    {
        try {
            $result = Delete::execute($id);
            return $this->success([], $result['message']);
        } catch (Exception $exception) {
            return $this->failed([], getMessage('users_not_deleted'));

        }
    }
}
