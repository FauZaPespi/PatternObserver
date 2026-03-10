<?php

namespace Makosc\Observer\Models;

use Makosc\Observer\Database\Database;
use PDO;
use PDOException;

class UserManager
{
    private static string $table = 'users';

    public static function createUser(string $username, string $password, ?string $email = null): ?User
    {
        $db = Database::getInstance();

        // Vérifier si l'utilisateur existe déjà
        if (self::findByUsername($username)) {
            return null;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (username, password, email) VALUES (:username, :password, :email)");
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
                ':email' => $email,
            ]);

            $id = (int)$db->lastInsertId();
            return self::findById($id);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return null;
        }
    }

    public static function findById(int $id): ?User
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch();

            if ($data) {
                return User::fromArray($data);
            }
        } catch (PDOException $e) {
            error_log("Error finding user by ID: " . $e->getMessage());
        }

        return null;
    }

    public static function findByUsername(string $username): ?User
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $data = $stmt->fetch();

            if ($data) {
                return User::fromArray($data);
            }
        } catch (PDOException $e) {
            error_log("Error finding user by username: " . $e->getMessage());
        }

        return null;
    }

    public static function authenticate(string $username, string $password): ?User
    {
        $user = self::findByUsername($username);

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    public static function getAllUsers(): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->query("SELECT * FROM " . self::$table . " ORDER BY created_at DESC");
            $users = [];

            while ($data = $stmt->fetch()) {
                $users[] = User::fromArray($data);
            }

            return $users;
        } catch (PDOException $e) {
            error_log("Error fetching all users: " . $e->getMessage());
            return [];
        }
    }

    public static function updateUser(int $id, array $data): bool
    {
        $db = Database::getInstance();

        $allowedFields = ['username', 'email'];
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $fields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($fields)) {
            return false;
        }

        try {
            $sql = "UPDATE " . self::$table . " SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
            $stmt = $db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteUser(int $id): bool
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public static function changePassword(int $id, string $newPassword): bool
    {
        $db = Database::getInstance();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            $stmt = $db->prepare("UPDATE " . self::$table . " SET password = :password WHERE id = :id");
            return $stmt->execute([
                ':id' => $id,
                ':password' => $hashedPassword,
            ]);
        } catch (PDOException $e) {
            error_log("Error changing password: " . $e->getMessage());
            return false;
        }
    }
}
