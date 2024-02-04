<?php

namespace Model;


class  Product extends Model
{
    public function getAll(): array
    {
        $stmt = self::getPDO()->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }
}