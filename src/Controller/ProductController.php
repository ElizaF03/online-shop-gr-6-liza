<?php

class ProductController
{
    public function getCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }

        require_once './../Model/Product.php';
        $productModel = new Product();
        $products = $productModel->getAll();
        require_once './../View/catalog.phtml';
    }

    public function getCart()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        require_once './../Model/UserProduct.php';
        $userProductModel = new UserProduct();
        $products = $userProductModel->getAll($userId);
        require_once './../View/cart.phtml';
    }

    public function addProductToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /get_login.phtml');
        } else {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $user_id = $_SESSION['user_id'];
            require_once './../Model/UserProduct.php';
            $userProductModel = new UserProduct();
            $cart = $userProductModel->getOne($user_id, $product_id);
            if ($_POST['button'] === 'plus') {
                if (empty($cart)) {
                    $userProductModel->createProductInCart($user_id, $product_id, $quantity);
                } else {
                    $userProductModel->addProduct($product_id, $user_id);
                }
            }
        }


        require_once './../View/catalog.phtml';

    }

    public function removeProductToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /get_login.phtml');
        } else {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $user_id = $_SESSION['user_id'];
            require_once './../Model/UserProduct.php';
            $userProductModel = new UserProduct();
            $quantity = $userProductModel->getQuantity($user_id, $product_id);
            if ($_POST['button'] === 'minus') {
                if ($quantity[0] <= 1) {
                    $userProductModel->deleteProductInCart($user_id, $product_id);
                } else {
                    $userProductModel->minusProduct($product_id, $user_id);
                }
            }
        }


        require_once './../View/catalog.phtml';

    }

    public function countProductInCart()
    {
        $user_id = $_SESSION['user_id'];
        require_once './../Model/UserProduct.php';
        $userProductModel = new UserProduct();
        $productsInCart = $userProductModel->getAll($user_id);
        $sum = 0;
        foreach ($productsInCart as $product) {
            $sum = $sum + $product['quantity'];
        }
        return $sum;

    }
}