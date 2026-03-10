<?php

class User {
    public int $Id;
    public string $Username;
    public string $Password;
    public function __construct($usrnm, $psw, $id)
    {
        $Username = $usrnm;
        $Password = $psw;
        $Id = $id;
    }
}