<?php

namespace Tests;

use App\Database\Database;
use PDO;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected PDO $db;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::getInstance()->getConnection();

        // Start every test with an empty users table.
        $this->db->exec('DELETE FROM users');

        // Flight uses a shared response object, so clear any response
        // body left behind by a previous test.
        \Flight::response()->clearBody();

        // Reset the status code as well.
        \Flight::response()->status(200);

	\Flight::request()->data->setData([]);
    }

    protected function tearDown(): void
    {
        $this->db->exec('DELETE FROM users');

        \Flight::response()->clearBody();
        \Flight::response()->status(200);
	\Flight::request()->data->setData([]);

        parent::tearDown();
    }
}
