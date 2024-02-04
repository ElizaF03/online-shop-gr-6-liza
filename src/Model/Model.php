<?php

namespace Model;

use PDO;

class Model
{
    protected static PDO $pdo;

    public static function getPDO(): PDO
    {
        self::$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username: "elizaveta", password: "qwerty");
        return self::$pdo;
    }
}