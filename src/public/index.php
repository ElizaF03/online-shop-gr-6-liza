<?php

$requestUri= $_SERVER['REQUEST_URI'];
$requestMethod=$_SERVER['REQUEST_METHOD'];
if($requestUri ==='/login'){
    require_once './../Controller/UserController.php';
    $obj=new UserController();
    if($requestMethod ==='GET'){
        $obj->getLogin();
    }elseif ($requestMethod ==='POST'){
        $obj->postLogin();
    }else{
        echo "Метод $requestMethod поддерживается для адреса $requestUri";
    }
}elseif ($requestUri ==='/registrate'){
    require_once './../Controller/UserController.php';
    $obj=new UserController();
    if($requestMethod ==='GET'){
        $obj->getRegistrate();
    }elseif ($requestMethod ==='POST'){
        $obj->postRegistrate();
    }else{
        echo "Метод $requestMethod поддерживается для адреса $requestUri";
    }
}elseif ($requestUri ==='/catalog'){
    require_once './../Controller/ProductController.php';
    $obj= new ProductController();
    if($requestMethod==="POST"){
        $obj->getCatalog();
        $obj->addProductToCart();
    }

} elseif ($requestUri ==='/cart'){
    require_once './../Controller/ProductController.php';
    $obj= new ProductController();
    $obj->getCart();
} else{
    require_once './../View/404.html';
}
