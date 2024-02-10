<?php

namespace Controller;

use Model\User;
use Request\RegistrateRequest;
use Request\LoginRequest;

class UserController
{
private User $user;
/*public function __construct()
{
$this->user= new User();
}*/
    public function getRegistrate(): void
    {
        require_once './../View/get_registrate.phtml';
    }

    public function postRegistrate(RegistrateRequest $request)
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors=$request->validate();

        if (empty($errors)) {

            $data = User::getOneByEmail($email);
            if ($data=== false) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                User::addInfo($username, $email, $hash);
            } else {
                echo 'Такой позльзователь уже зарегистрирован';
            }
        }

        require_once './../View/get_registrate.phtml';
    }




    public function getLogin(): void
    {
        require_once './../View/get_login.phtml';
    }

    public  function postLogin(LoginRequest $request): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = $request->validate();
        if (empty($errors)) {
            $user = User::getOneByEmail($email);
            if (!$user){
                echo 'Пользователь не зарегистрирован';
            } else {
                if (password_verify($password, $user->getPassword())) {
                    session_start();
                    $_SESSION['user_id'] = $user->getId();
                    header('Location: /catalog');
                    echo 'Авторизация прошла успешно';
                } else {
                    echo 'Неверный пароль или логин';
                }
            }
        }
        require_once './../View/get_login.phtml';
    }
}