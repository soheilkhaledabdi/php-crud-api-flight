<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class User
{
    public $id;
    public $name;

    public function __construct($id = null, $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getAll()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id,name FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id,name FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO users (name) VALUES (:name)");
        $stmt->bindParam(':name', $this->name);
        $stmt->execute();
    }

    public function update()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET name = :name  =  WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->execute();
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
