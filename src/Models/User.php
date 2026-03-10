<?php

namespace Makosc\Observer\Models;

class User
{
    public ?int $id = null;
    public string $username;
    public string $password;
    public ?string $email = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(string $username = '', string $password = '', ?int $id = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
    }

    public static function fromArray(array $data): self
    {
        $user = new self();
        $user->id = $data['id'] ?? null;
        $user->username = $data['username'] ?? '';
        $user->password = $data['password'] ?? '';
        $user->email = $data['email'] ?? null;
        $user->created_at = $data['created_at'] ?? null;
        $user->updated_at = $data['updated_at'] ?? null;
        return $user;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
