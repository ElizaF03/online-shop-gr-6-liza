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

        $quantityProducts = $this->countProductInCart();
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
        $cost = $this->countCost();
        $userProducts = UserProduct::getAll($userId);
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
            if ($_POST['button'] === 'plus') {
                if (!$userProduct) {
                    UserProduct::createProductInCart($userId, $productId, $quantity);
                } else {
                    UserProduct::addProduct($productId, $userId);
                }
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
            if ($_POST['button'] === 'minus') {
                if (!empty($userProduct)) {
                    if ($userProduct->getQuantity() === 1) {
                        UserProduct::deleteProductFromCart($userId, $productId);
                    } else {
                        UserProduct::minusProduct($productId, $userId);
                    }
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
        $productsInCart = UserProduct::getAll($userId);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $sum = $sum + $product['quantity'];
        }
        return $sum;
    }

    public function countCost(): int
    {
        $userId = $_SESSION['user_id'];
        $productsInCart = UserProduct::getAll($userId);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $price = $product['quantity'] * $product['price'];
            $sum = $sum + $price;
        }
        return $sum;
    }
}