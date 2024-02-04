<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;

    public function __construct(int $id, string $username, string $email, string $password)
    {
        $this->id=$id;
        $this->username=$username;
        $this->email=$email;
        $this->password=$password;
    }


    public static function getOneByEmail($email):false|User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE email =:email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        if (!$data) {
            return false;
        }
        return new User($data['id'],$data['username'],$data['email'],$data['password']);

    }

    public static function addInfo(string $username, string $email, string $hash): void
    {
        $stmt = self::getPDO()->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :hash)');
        $stmt->execute(['username' => $username, 'email' => $email, 'hash' => $hash]);
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}