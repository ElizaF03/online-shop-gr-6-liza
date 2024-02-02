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

$app->post('/registrate',UserController::class, 'postRegistrate');
$app->post('/login', UserController::class, 'postLogin');
$app->post('/remove-product', ProductController::class, 'removeProductFromCart');
$app->post('/add-product', ProductController::class, 'addProductToCart');
$app->run();