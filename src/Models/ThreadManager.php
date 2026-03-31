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
            return self::findById($id);
        } catch (PDOException $e) {
            error_log("Error creating thread: " . $e->getMessage());
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

    /** Returns the first thread found for a user. Use getAllByUserId() to get all threads. */
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

    /** Returns all threads for a user, ordered newest first. */
    public static function getAllByUserId(int $userId): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare(
                "SELECT * FROM " . self::$table . " WHERE user_id = :user_id ORDER BY created_at DESC"
            );
            $stmt->execute([':user_id' => $userId]);
            $threads = [];

            while ($data = $stmt->fetch()) {
                $threads[] = Thread::fromArray($data);
            }

            return $threads;
        } catch (PDOException $e) {
            error_log("Error fetching threads by user ID: " . $e->getMessage());
            return [];
        }
    }

    public static function getAllByFollowing(int $userId): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare(
                "SELECT t.* FROM " . self::$table . " t
                 INNER JOIN follows f ON f.followed_id = t.user_id
                 WHERE f.follower_id = :user_id
                 ORDER BY t.created_at DESC"
            );
            $stmt->execute([':user_id' => $userId]);
            $threads = [];

            while ($data = $stmt->fetch()) {
                $threads[] = Thread::fromArray($data);
            }

            return $threads;
        } catch (PDOException $e) {
            error_log("Error fetching following threads: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Returns all threads with author username, ordered newest first.
     * Each element is an array with keys: thread (Thread object) and author_username (string).
     */
    public static function getAllThreadsWithAuthors(): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->query(
                "SELECT t.*, u.username AS author_username
                 FROM " . self::$table . " t
                 INNER JOIN users u ON u.id = t.user_id
                 ORDER BY t.created_at DESC"
            );
            $results = [];

            while ($data = $stmt->fetch()) {
                $results[] = [
                    'thread' => Thread::fromArray($data),
                    'author_username' => $data['author_username'],
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Error fetching threads with authors: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Returns threads from followed users with author username, ordered newest first.
     * Each element is an array with keys: thread (Thread object) and author_username (string).
     */
    public static function getAllByFollowingWithAuthors(int $userId): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare(
                "SELECT t.*, u.username AS author_username
                 FROM " . self::$table . " t
                 INNER JOIN follows f ON f.followed_id = t.user_id
                 INNER JOIN users u ON u.id = t.user_id
                 WHERE f.follower_id = :user_id
                 ORDER BY t.created_at DESC"
            );
            $stmt->execute([':user_id' => $userId]);
            $results = [];

            while ($data = $stmt->fetch()) {
                $results[] = [
                    'thread' => Thread::fromArray($data),
                    'author_username' => $data['author_username'],
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Error fetching following threads with authors: " . $e->getMessage());
            return [];
        }
    }
}
