<?php
use App\Actions\Users\Delete;
use App\Actions\Users\Update;
use App\Actions\Users\Create;
use App\Models\User;

it('creates a user', function () {
    Create::execute([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $user = User::getById(
        (int) $this->db->lastInsertId()
    );

    expect($user)
        ->not->toBeFalse()
        ->and($user['name'])->toBe('Test User')
        ->and($user['email'])->toBe('test@example.com');
});
it('retrieves an existing user', function () {
    Create::execute([
        'name' => 'Qasim Test',
        'email' => 'qasim@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    $user = User::getById($id);

    expect($user)
        ->not->toBeFalse()
        ->and($user['id'])->toBe($id)
        ->and($user['name'])->toBe('Qasim Test')
        ->and($user['email'])->toBe('qasim@example.com');
});
it('returns false when user does not exist', function () {
    $user = User::getById(999999);

    expect($user)->toBeFalse();
});
it('updates an existing user', function () {
    Create::execute([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    Update::execute($id, [
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);

    $user = User::getById($id);

    expect($user)
        ->not->toBeFalse()
        ->and($user['name'])->toBe('New Name')
        ->and($user['email'])->toBe('new@example.com');
});
it('deletes an existing user', function () {
    Create::execute([
        'name' => 'Delete Me',
        'email' => 'delete@example.com',
    ]);

    $id = (int) $this->db->lastInsertId();

    Delete::execute($id);

    $user = User::getById($id);

    expect($user)->toBeFalse();
});
it('rejects duplicate email addresses', function () {
    Create::execute([
        'name' => 'First User',
        'email' => 'duplicate@example.com',
    ]);

    expect(fn () => Create::execute([
        'name' => 'Second User',
        'email' => 'duplicate@example.com',
    ]))->toThrow(PDOException::class);
});
