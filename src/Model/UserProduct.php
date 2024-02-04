<?php

namespace Model;

class UserProduct extends Model
{
    public function getAll(int $user_id): array
    {
        $stmt = self::getPDO()->query("SELECT * FROM user_products JOIN products ON user_products.product_id=products.id WHERE user_id = {$user_id}");
        return $stmt->fetchAll();
    }

    public function getOne(int $user_id, int $product_id):mixed
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id LIMIT 1');
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        return $stmt->fetch();
    }

    public function getQuantity(int $user_id, int $product_id):mixed
    {
        $stmt = self::getPDO()->query("SELECT quantity FROM user_products WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();


    }

    public function createProductInCart(int $user_id, int $product_id,int $quantity): void
    {
        $stmt = self::getPDO()->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    public function deleteProductFromCart(int $user_id, int $product_id): void
    {
        self::getPDO()->query("DELETE FROM user_products WHERE  product_id = {$product_id} AND user_id = {$user_id} ");

    }


    public function addProduct(int $product_id, int $user_id):mixed
    {
        $stmt = self::getPDO()->query("UPDATE user_products SET quantity = quantity+1  WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();

    }

    public function minusProduct(int $product_id, int $user_id):mixed
    {
        $stmt = self::getPDO()->query("UPDATE user_products SET quantity = quantity-1  WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();

    }
}