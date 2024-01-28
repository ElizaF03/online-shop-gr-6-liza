<?php

require_once 'Model.php';
class UserProduct extends Model
{
public function addProduct($user_id, $product_id, $quantity)
{
    $stmt=$this->pdo->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
    $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
}
    public function getAll($user_id):array
    {
        $stmt=$this->pdo->query("SELECT * FROM user_products JOIN products ON user_products.product_id=products.id WHERE user_id = {$user_id}");
        return $stmt->fetchAll();
    }

public function countProduct($user_id)
{
    $stmt=$this->pdo->query("SELECT COUNT(*) FROM user_products WHERE user_id = {$user_id}");
    return $stmt->fetchAll();
}
}