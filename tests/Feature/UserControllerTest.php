<?php

use App\Actions\Users\Create;
use App\Controllers\UserController;
use App\Models\User;

it('returns an existing user through the controller', function () {
    Create::execute([
        'name' => 'Controller Test',
        'email' => 'controller@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    $controller = new UserController();
    $controller->show($id);

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    expect($flightResponse->status())
        ->toBe(200)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeTrue()
        ->and($response['data']['id'])->toBe($id)
        ->and($response['data']['name'])->toBe('Controller Test')
        ->and($response['data']['email'])->toBe('controller@example.com');
});

it('returns 404 when user does not exist', function () {
    $controller = new UserController();
    $controller->show(999999);

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    expect($flightResponse->status())
        ->toBe(404)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeFalse()
        ->and($response['data'])->toBe([])
        ->and($response['message'])->toBe(getMessage('users_not_found'));
});

it('returns all users through the controller', function () {
    Create::execute([
        'name' => 'First User',
        'email' => 'first@example.com',
    ]);

    Create::execute([
        'name' => 'Second User',
        'email' => 'second@example.com',
    ]);

    $controller = new UserController();
    $controller->index();

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    expect($flightResponse->status())
        ->toBe(200)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeTrue()
        ->and($response['data'])->toHaveCount(2)
        ->and($response['data'][0]['email'])->toBe('first@example.com')
        ->and($response['data'][1]['email'])->toBe('second@example.com');
});

it('creates a user through the controller', function () {
    Flight::request()->data->setData([
        'name' => 'New API User',
        'email' => 'newapi@example.com',
    ]);

    $controller = new UserController();
    $controller->store();

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    $stmt = $this->db->prepare(
        'SELECT * FROM users WHERE email = :email'
    );

    $stmt->execute([
        'email' => 'newapi@example.com',
    ]);

    $user = $stmt->fetch();

    expect($flightResponse->status())
        ->toBe(201)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeTrue()
        ->and($user)->not->toBeFalse()
        ->and($user['name'])->toBe('New API User')
        ->and($user['email'])->toBe('newapi@example.com');
});

it('returns 400 when creating a user with invalid input', function () {
    Flight::request()->data->setData([
        'name' => '',
        'email' => 'not-an-email',
    ]);

    $controller = new UserController();
    $controller->store();

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    $count = (int) $this->db
        ->query('SELECT COUNT(*) FROM users')
        ->fetchColumn();

    expect($flightResponse->status())
        ->toBe(400)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeFalse()
        ->and($response['message'])->toBe(getMessage('invalid_input'))
        ->and($response['data'])->not->toBeEmpty()
        ->and($count)->toBe(0);
});

it('updates a user through the controller', function () {
    Create::execute([
        'name' => 'Before Update',
        'email' => 'before@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    Flight::request()->data->setData([
        'name' => 'After Update',
        'email' => 'after@example.com',
    ]);

    $controller = new UserController();
    $controller->update($id);

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    $user = User::getById($id);

    expect($flightResponse->status())
        ->toBe(200)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeTrue()
        ->and($user['name'])->toBe('After Update')
        ->and($user['email'])->toBe('after@example.com');
});

it('returns 400 when updating a user with invalid input', function () {
    Create::execute([
        'name' => 'Original User',
        'email' => 'original@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    Flight::request()->data->setData([
        'name' => '',
        'email' => 'invalid-email',
    ]);

    $controller = new UserController();
    $controller->update($id);

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    $user = User::getById($id);

    expect($flightResponse->status())
        ->toBe(400)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeFalse()
        ->and($response['message'])->toBe(getMessage('invalid_input'))
        ->and($response['data'])->not->toBeEmpty()
        ->and($user['name'])->toBe('Original User')
        ->and($user['email'])->toBe('original@example.com');
});

it('deletes a user through the controller', function () {
    Create::execute([
        'name' => 'Delete Controller',
        'email' => 'delete-controller@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    $controller = new UserController();
    $controller->delete($id);

    $flightResponse = Flight::response();
    $response = json_decode($flightResponse->getBody(), true);

    $user = User::getById($id);

    expect($flightResponse->status())
        ->toBe(200)
        ->and($response)->toBeArray()
        ->and($response['status'])->toBeTrue()
        ->and($user)->toBeFalse();
});
