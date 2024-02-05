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
        $products = UserProduct::getAll($userId);
        require_once './../View/cart.phtml';
    }

    public function addProductToCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $user_id = $_SESSION['user_id'];
            $userProduct = UserProduct::getOne($user_id, $product_id);
            if ($_POST['button'] === 'plus') {
                if ($userProduct===false) {
                    UserProduct::createProductInCart($user_id, $product_id, $quantity);
                } else {
                    UserProduct::addProduct($product_id, $user_id);
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
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];
            $userProduct =  UserProduct::getOne($user_id, $product_id);
            if ($_POST['button'] === 'minus') {
                if (!empty($userProduct)) {
                    if ($userProduct->getQuantity() ===1) {
                        UserProduct::deleteProductFromCart($user_id, $product_id);
                    } else {
                       UserProduct::minusProduct($product_id, $user_id);
                    }
                }

            }
        }
        $quantityProducts =  $this->countProductInCart();
        $products = Product::getAll();
        require_once './../View/catalog.phtml';
    }


    public function countProductInCart():int
    {
        $user_id = $_SESSION['user_id'];
        $productsInCart =  UserProduct::getAll($user_id);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $sum = $sum + $product['quantity'];
        }
        return $sum;
    }

    public function countCost():int
    {
        $user_id = $_SESSION['user_id'];
        $productsInCart = UserProduct::getAll($user_id);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $price = $product['quantity'] * $product['price'];
            $sum = $sum + $price;
        }
        return $sum;
    }
}