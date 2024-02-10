<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class ProductController
{
    public function getCatalog(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $sum = $this->countProductInCart();
        $products = Product::getAll();
        require_once './../View/catalog.phtml';
    }

    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $userProducts = UserProduct::getAllByUserId($userId);
        foreach ($userProducts as $userProduct) {
            $ids[] = $userProduct->getProductId();

        }
        $products = Product::getAllByIds($ids);
        $cost = $this->countCost($products, $userProducts);

        require_once './../View/cart.phtml';
    }

    public function addProductToCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user_id'];
            $userProduct = UserProduct::getOne($userId, $productId);
            if (!$userProduct) {
                UserProduct::createProductInCart($userId, $productId, $quantity);
            } else {
                UserProduct::addProduct($productId, $userId);
            }
        }
        $quantityProducts = $this->countProductInCart();
        $products = Product::getAll();
        require_once './../View/catalog.phtml';
    }

    public function removeProductFromCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $productId = $_POST['product_id'];
            $userId = $_SESSION['user_id'];
            $userProduct = UserProduct::getOne($userId, $productId);
            if (!empty($userProduct)) {
                if ($userProduct->getQuantity() === 1) {
                    UserProduct::deleteProductFromCart($userId, $productId);
                } else {
                    UserProduct::minusProduct($productId, $userId);
                }
            }
        }
        $quantityProducts = $this->countProductInCart();
        $products = Product::getAll();
        require_once './../View/catalog.phtml';
    }


    public function countProductInCart(): int
    {
        $userId = $_SESSION['user_id'];
        $productsInCart = UserProduct::getAllByUserId($userId);
        $sum = 0;
        foreach ($productsInCart as $userProduct) {
            $sum = $sum + $userProduct->getQuantity();
        }
        return $sum;
    }

    public function countCost($products, $userProducts): int
    {
        $sum = 0;
        foreach ($products as $product) {
            $price[] = $product->getPrice();

        }
        foreach ($userProducts as $userProduct) {
            $quantity[] = $userProduct->getQuantity();
        }
        $l = count($userProducts);
        for ($i = 0; $i < $l; $i++) {
            $sum = $sum + $quantity[$i] * $price[$i];;
        }
        return $sum;
    }
}