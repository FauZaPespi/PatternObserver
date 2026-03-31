<?php

namespace Makosc\Observer\Models;

use Makosc\Observer\Database\Database;
use PDOException;

class FollowManager
{
    private static string $table = 'follows';

    public static function follow(int $followerId, int $followedId): bool
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "INSERT IGNORE INTO " . self::$table . " (follower_id, followed_id) VALUES (:follower_id, :followed_id)"
            );
            return $stmt->execute([':follower_id' => $followerId, ':followed_id' => $followedId]);
        } catch (PDOException $e) {
            error_log("Error following user: " . $e->getMessage());
            return false;
        }
    }

    public static function unfollow(int $followerId, int $followedId): bool
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "DELETE FROM " . self::$table . " WHERE follower_id = :follower_id AND followed_id = :followed_id"
            );
            return $stmt->execute([':follower_id' => $followerId, ':followed_id' => $followedId]);
        } catch (PDOException $e) {
            error_log("Error unfollowing user: " . $e->getMessage());
            return false;
        }
    }

    public static function isFollowing(int $followerId, int $followedId): bool
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "SELECT 1 FROM " . self::$table . " WHERE follower_id = :follower_id AND followed_id = :followed_id"
            );
            $stmt->execute([':follower_id' => $followerId, ':followed_id' => $followedId]);
            return (bool) $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error checking follow status: " . $e->getMessage());
            return false;
        }
    }

    public static function getFollowerCount(int $userId): int
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "SELECT COUNT(*) FROM " . self::$table . " WHERE followed_id = :user_id"
            );
            $stmt->execute([':user_id' => $userId]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error counting followers: " . $e->getMessage());
            return 0;
        }
    }

    public static function getFollowingCount(int $userId): int
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "SELECT COUNT(*) FROM " . self::$table . " WHERE follower_id = :user_id"
            );
            $stmt->execute([':user_id' => $userId]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error counting following: " . $e->getMessage());
            return 0;
        }
    }

    public static function getFollowing(int $userId): array
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "SELECT u.* FROM users u
                 INNER JOIN " . self::$table . " f ON f.followed_id = u.id
                 WHERE f.follower_id = :user_id
                 ORDER BY f.created_at DESC"
            );
            $stmt->execute([':user_id' => $userId]);
            $users = [];
            while ($data = $stmt->fetch()) {
                $users[] = User::fromArray($data);
            }
            return $users;
        } catch (PDOException $e) {
            error_log("Error fetching following list: " . $e->getMessage());
            return [];
        }
    }

    public static function getFollowers(int $userId): array
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare(
                "SELECT u.* FROM users u
                 INNER JOIN " . self::$table . " f ON f.follower_id = u.id
                 WHERE f.followed_id = :user_id
                 ORDER BY f.created_at DESC"
            );
            $stmt->execute([':user_id' => $userId]);
            $users = [];
            while ($data = $stmt->fetch()) {
                $users[] = User::fromArray($data);
            }
            return $users;
        } catch (PDOException $e) {
            error_log("Error fetching followers list: " . $e->getMessage());
            return [];
        }
    }
}
