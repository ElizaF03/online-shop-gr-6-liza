<?php

require_once 'Model.php';
class UserProduct extends Model
{
public function addProduct($user_id, $product_id)
{
    $stmt=$this->pdo->prepare('INSERT INTO user_products (user_id, product_id) VALUES (:user_id, :product_id)');
    $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
}
public function countProduct()
{

}
}