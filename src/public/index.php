<?php

use Controller\UserController;
use Controller\ProductController;
require_once './../Autoloader.php';
require_once './../App.php';

Autoloader::registrate();

$app = new App();
$app->get('/registrate', UserController::class, 'getRegistrate');
$app->get('/login', UserController::class, 'getLogin');
$app->get('/catalog',ProductController::class, 'getCatalog');
$app->get('/cart',ProductController::class, 'getCart');
$app->post('/registrate',UserController::class, 'postRegistrate', \Request\RegistrateRequest::class);
$app->post('/login', UserController::class, 'postLogin',\Request\LoginRequest::class);
$app->post('/remove-product', ProductController::class, 'removeProductFromCart');
$app->post('/minus-product', ProductController::class, 'minusProductFromCart');
$app->post('/add-product', ProductController::class, 'addProductToCart');
$app->post('/plus-product', ProductController::class, 'plusProductToCart');
$app->run();