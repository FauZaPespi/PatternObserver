<?php

namespace Makosc\Observer\Models;

use Makosc\Observer\Database\Database;
use PDO;
use PDOException;
use Makosc\Observer\Models\Thread;

class ThreadManager
{
    private static string $table = 'threads';


        public static function createThread(Thread $thread): ?Thread
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (content, user_id) VALUES (:content, :user_id)");
            $stmt->execute([
                ':content' => $thread->Content,
                ':user_id' => $thread->UserId,
            ]);

            $id = (int)$db->lastInsertId();

            $id = (int)$db->lastInsertId();
            return self::findById($id);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return null;
        }
    }

    public static function findById(int $id): ?Thread
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch();

            if ($data) {
                return Thread::fromArray($data);
            }
        } catch (PDOException $e) {
            error_log("Error finding thread by ID: " . $e->getMessage());
        }

        return null;
    }

    public static function findByUserId(int $userId): ?Thread
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $userId]);
            $data = $stmt->fetch();

            if ($data) {
                return Thread::fromArray($data);
            }
        } catch (PDOException $e) {
            error_log("Error finding thread by user ID  : " . $e->getMessage());
        }

        return null;
    }

    public static function getAllThreads(): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->query("SELECT * FROM " . self::$table . " ORDER BY created_at DESC");
            $threads = [];

            while ($data = $stmt->fetch()) {
                $threads[] = Thread::fromArray($data);
            }

            return $threads;
        } catch (PDOException $e) {
            error_log("Error fetching all threads: " . $e->getMessage());
            return [];
        }
    }
}
