<?php

class ProductController
{
public function getCatalog()
    {
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: /get_login.php');
        }
        $pdo= new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username:"elizaveta", password:"qwerty");
    $stmt=$pdo->query('SELECT * FROM products');
   $products= $stmt->fetchAll();
    require_once './../View/catalog.php';
    }
public function addProduct()
{

}
}