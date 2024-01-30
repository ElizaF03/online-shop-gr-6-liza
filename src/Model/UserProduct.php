<?php

namespace Model;

class UserProduct extends Model
{
    public function getQuantity($user_id, $product_id)
    {
        $stmt = $this->pdo->query("SELECT quantity FROM user_products WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();


    }

    public function createProductInCart($user_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    public function deleteProductInCart($user_id, $product_id)
    {
        $this->pdo->query("DELETE FROM user_products WHERE  product_id = {$product_id} AND user_id = {$user_id} ");

    }

    public function getAll($user_id): array
    {
        $stmt = $this->pdo->query("SELECT * FROM user_products JOIN products ON user_products.product_id=products.id WHERE user_id = {$user_id}");
        return $stmt->fetchAll();
    }

    public function getOne($user_id, $product_id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id LIMIT 1');
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        return $stmt->fetch();
    }



    public function addProduct($product_id, $user_id)
    {
        $stmt = $this->pdo->query("UPDATE user_products SET quantity = quantity+1  WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();

    }

    public function minusProduct($product_id, $user_id)
    {
        $stmt = $this->pdo->query("UPDATE user_products SET quantity = quantity-1  WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();

    }
}