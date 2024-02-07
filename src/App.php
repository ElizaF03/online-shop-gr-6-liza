<?php

use Controller\ProductController;
use Controller\UserController;
use Request\Request;

class App
{
    private array $routes = [];


    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];
                $class = $handler['class'];
                $method = $handler['method'];
                $obj = new $class();
                if(isset($handler['request'])){
                    $request= new $handler['request']($requestMethod, $requestUri, headers_list(), $_REQUEST);
                } else {
                    $request = new \Request\Request($requestMethod, $requestUri, headers_list(), $_REQUEST);
                }
                $obj->$method($request);
            } else {
                echo "Метод $requestMethod не поддерживается для адреса $requestUri";
            }
        } else {
            require_once './../View/404.html';
        }
    }



public
function get(string $uri, string $class, string $handler, string $request=null): void
{
    $this->routes[$uri]['GET'] = [
        'class' => $class,
        'method' => $handler,
        'request'=>$request,
    ];
}

public
function post(string $uri, string $class, string $handler, string $request=null): void
{
    $this->routes[$uri]['POST'] = [
        'class' => $class,
        'method' => $handler,
        'request'=>$request,
    ];
}
}