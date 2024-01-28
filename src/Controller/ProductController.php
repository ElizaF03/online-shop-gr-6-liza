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
        require_once './../View/cart.phtml';
    }
public function addProductToCart()
{
   //session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: /get_login.phtml');
    }else{
        $product_id=$_POST['product_id'];
        $user_id=$_SESSION['user_id'];
        require_once './../Model/UserProduct.php';
        $userProductModel= new UserProduct();
        $userProductModel->addProduct($user_id, $product_id);

    }
    require_once './../View/catalog.phtml';

}
public function getAddProductForm()
{
    require_once './../View/catalog.phtml';
}
}