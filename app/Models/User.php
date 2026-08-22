<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class User
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
    ) {
    }

    public static function getAll(): array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query('SELECT id, name, email, created_at, updated_at FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT id, name, email, created_at, updated_at FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save(): void
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('INSERT INTO users (name, email, created_at, updated_at) VALUES (:name, :email, NOW(), NOW())');
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
    }

    public function update(): void
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('UPDATE users SET name = :name, email = :email, updated_at = NOW() WHERE id = :id');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
    }

    public static function delete($id): void
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
