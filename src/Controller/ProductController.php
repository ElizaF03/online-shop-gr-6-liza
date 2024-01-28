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
public function addProduct()
{
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: /get_login.phtml');
    }
    //$pdo= new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username:"elizaveta", password:"qwerty");

}
}