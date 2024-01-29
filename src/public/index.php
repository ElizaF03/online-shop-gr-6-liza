<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$controllerAutoloader=function (string $class){
    $path= "./../Controller/$class.php";
    if(file_exists($path)){
        require_once $path;
        return true;
    }
    return false;
};
$modelAutoloader= function (string $class){
    $path="./../Model/$class.php";
    if(file_exists($path)){
        require_once $path;
        return true;
    }
    return false;
};
spl_autoload_register($controllerAutoloader);
spl_autoload_register($modelAutoloader);
if ($requestUri === '/login') {
    $obj = new UserController();
    if ($requestMethod === 'GET') {
        $obj->getLogin();
    } elseif ($requestMethod === 'POST') {
        $obj->postLogin();
    } else {
        echo "Метод $requestMethod поддерживается для адреса $requestUri";
    }
} elseif ($requestUri === '/registrate') {
    $obj = new UserController();
    if ($requestMethod === 'GET') {
        $obj->getRegistrate();
    } elseif ($requestMethod === 'POST') {
        $obj->postRegistrate();
    } else {
        echo "Метод $requestMethod поддерживается для адреса $requestUri";
    }
} elseif ($requestUri === '/catalog') {
    $obj = new ProductController();
    $obj->getCatalog();
    if ($requestMethod === "POST") {
        if ($_POST['button'] === 'plus') {
            $obj->getCatalog();
            $obj->addProductToCart();
        } elseif ($_POST['button'] === 'minus') {
            $obj->getCatalog();
            $obj->removeProductToCart();

        }
    }
} elseif ($requestUri === '/cart') {
    $obj = new ProductController();
    $obj->getCart();
} else {
    require_once './../View/404.html';
}
