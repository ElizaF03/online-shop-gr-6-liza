<?php

class ProductController
{
public function getCatalog()
    {
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: /login');
        }

    require_once './../Model/Product.php';
    $productModel= new Product();
    $products=$productModel->getAll();
    require_once './../View/catalog.phtml';
    }
    public function getCart()
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
        $userId=$_SESSION['user_id'];
        require_once './../Model/UserProduct.php';
        $userProductModel= new UserProduct();
        $products=$userProductModel->getAll($userId);
        require_once './../View/cart.phtml';
    }
public function addProductToCart()
{
    if(!isset($_SESSION['user_id'])){
        header('Location: /get_login.phtml');
    }else{
        $product_id=$_POST['product_id'];
        $quantity=$_POST['quantity'];
        $user_id=$_SESSION['user_id'];
        require_once './../Model/UserProduct.php';
        $userProductModel= new UserProduct();
        $userProductModel->addProduct($user_id, $product_id, $quantity);
    }
    require_once './../View/catalog.phtml';

}
public function countProductInCart()
{
    require_once './../Model/UserProduct.php';
    $userProductModel= new UserProduct();
   return $userProductModel->countProduct($_SESSION['user_id']);
}
public function removeProductToCart()
{
    if(!isset($_SESSION['user_id'])){
        header('Location: /get_login.phtml');
    }else{
        if ($_POST['button']=== 'minus'){
            $product_id=$_POST['product_id'];
            $quantity=$_POST['quantity'];
            $user_id=$_SESSION['user_id'];
            echo 'hello'; echo $user_id;
            require_once './../Model/UserProduct.php';
            $userProductModel= new UserProduct();
            $userProductModel->removeProduct($user_id, $product_id, $quantity);
        }

    }
    require_once './../View/catalog.phtml';
}
}