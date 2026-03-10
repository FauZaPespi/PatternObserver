<?php

namespace Makosc\Observer\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'mariadb';
            $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? '3306';
            $dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'observer_db';
            $user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'observer_user';
            $password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? 'observer_pass';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

            try {
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    private function __clone() {}
}
