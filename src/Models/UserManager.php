<?php
class UserManager
{
    public static $users = [];

    public static function createAnUser(string $username, string $password) {
        static->retrieveFromDatabase();
        $user = new User($username, $password, count(static::$users)+1);
        array_push(static::$users, $user);
        static->saveInDatabase();
        return $user;
    }

    public static function saveInDatabase()
    {
        $file = "../config/accounts.json";
        $json = json_encode(static::$users);
        file_put_contents($file, $json);
    }

    public static function retrieveFromDatabase()
    {
        $file = "../config/accounts.json";
        $json = file_get_contents($file);
        static::$users = json_decode($json, true);
    }
}
