<?php

namespace Model;

class User extends Model
{

    public function lookEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email =:email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function addInfo($username, $email, $hash)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :hash)');
        $stmt->execute(['username' => $username, 'email' => $email, 'hash' => $hash]);
    }
}