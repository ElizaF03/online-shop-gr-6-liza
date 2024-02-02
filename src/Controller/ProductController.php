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
        $productModel = new Product();
        $quantityProducts = $this->countProductInCart();
        $products = $productModel->getAll();
        require_once './../View/catalog.phtml';
    }

    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $userProductModel = new UserProduct();
        $cost = $this->countCost();
        $products = $userProductModel->getAll($userId);
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
            $userProductModel = new UserProduct();
            $userProduct = $userProductModel->getOne($user_id, $product_id);
            if ($_POST['button'] === 'plus') {
                if (empty($userProduct)) {
                    $userProductModel->createProductInCart($user_id, $product_id, $quantity);
                } else {
                    $userProductModel->addProduct($product_id, $user_id);
                }
            }
        }
        $productModel = new Product();
        $quantityProducts = $this->countProductInCart();
        $products = $productModel->getAll();
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
            $userProductModel = new UserProduct();
            $quantity = $userProductModel->getQuantity($user_id, $product_id);
            $userProduct = $userProductModel->getOne($user_id, $product_id);
            if ($_POST['button'] === 'minus') {
                if (!empty($userProduct)) {
                    if ($quantity[0] <= 1) {
                        $userProductModel->deleteProductFromCart($user_id, $product_id);
                    } else {
                        $userProductModel->minusProduct($product_id, $user_id);
                    }
                }

            }
        }
        $productModel = new Product();
        $quantityProducts = $this->countProductInCart();
        $products = $productModel->getAll();
        require_once './../View/catalog.phtml';
    }


    public function countProductInCart():int
    {
        $user_id = $_SESSION['user_id'];
        $userProductModel = new UserProduct();
        $productsInCart = $userProductModel->getAll($user_id);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $sum = $sum + $product['quantity'];
        }
        return $sum;
    }

    public function countCost():int
    {
        $user_id = $_SESSION['user_id'];
        $userProductModel = new UserProduct();
        $productsInCart = $userProductModel->getAll($user_id);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $price = $product['quantity'] * $product['price'];
            $sum = $sum + $price;
        }
        return $sum;
    }
}