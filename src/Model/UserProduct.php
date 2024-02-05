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

    public static function getAll(int $user_id): array
    {
        $stmt = self::getPDO()->query("SELECT * FROM user_products JOIN products ON user_products.product_id=products.id WHERE user_id = {$user_id}");
        return $stmt->fetchAll();
    }

    public static function getOne(int $user_id, int $product_id): false|UserProduct
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id LIMIT 1');
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $data = $stmt->fetch();
        if (!$data) {
            return false;
        }
        return new UserProduct($data['id'], $data['user_id'], $data['product_id'], $data['quantity']);
    }


    public static function createProductInCart(int $user_id, int $product_id, int $quantity): void
    {
        $stmt = self::getPDO()->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    public static function deleteProductFromCart(int $user_id, int $product_id): void
    {
        self::getPDO()->query("DELETE FROM user_products WHERE  product_id = {$product_id} AND user_id = {$user_id} ");

    }


    public static function addProduct(int $product_id, int $user_id): mixed
    {
        $stmt = self::getPDO()->query("UPDATE user_products SET quantity = quantity+1  WHERE product_id = {$product_id} AND user_id = {$user_id}");
        return $stmt->fetch();

    }

    public static function minusProduct(int $product_id, int $user_id): mixed
    {
        $stmt = self::getPDO()->query("UPDATE user_products SET quantity = quantity-1  WHERE product_id = {$product_id} AND user_id = {$user_id}");
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

    public function getQuantity(): null|int
    {
        return $this->quantity;
    }
}