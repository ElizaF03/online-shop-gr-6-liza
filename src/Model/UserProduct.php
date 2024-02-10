<?php

namespace Model;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;

    private int $quantity;

    public function __construct(int $id, int $userId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function getAllByUserId(int $userId): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id'=>$userId]);
        $products= $stmt->fetchAll();
        foreach ($products as $product){
            $data[]=new UserProduct($product['id'], $product['user_id'], $product['product_id'], $product['quantity']);
        }
        if(empty($data)){
            return null;
        }else{
            return $data;
        }

    }

    public static function getOne(int $userId, int $productId): false|UserProduct
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id LIMIT 1');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        $data = $stmt->fetch();
        if (!$data) {
            return false;
        }
        return new UserProduct($data['id'], $data['user_id'], $data['product_id'], $data['quantity']);
    }


    public static function createProductInCart(int $userId, int $productId, int $quantity): void
    {
        $stmt = self::getPDO()->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function deleteProductFromCart(int $userId, int $productId): void
    {
        self::getPDO()->query("DELETE FROM user_products WHERE  product_id = {$productId} AND user_id = {$userId} ");

    }


    public static function addProduct(int $productId, int $userId): mixed
    {
        $stmt = self::getPDO()->query("UPDATE user_products SET quantity = quantity+1  WHERE product_id = {$productId} AND user_id = {$userId}");
        return $stmt->fetch();

    }

    public static function minusProduct(int $productId, int $userId): mixed
    {
        $stmt = self::getPDO()->query("UPDATE user_products SET quantity = quantity-1  WHERE product_id = {$productId} AND user_id = {$userId}");
        return $stmt->fetch();

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}