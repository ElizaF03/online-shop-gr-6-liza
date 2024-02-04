<?php

namespace Controller;

use Model\User;

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

    public function postRegistrate(): void
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = $this->validate($_POST);

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

    private function validate(array $data): array
    {
        $errors = [];
        if (isset($data['username'])) {
            $username = $data['username'];
            if (empty($username)) {
                $errors['username'] = "Имя должно быть заполнено";
            }
            if (strlen($username) > 0 && strlen($username) < 2) {
                $errors['username'] = "Имя должно быть не менее 2-х символов";
            }
        } else {
            $errors['email'] = 'Поле username не указано';
        }
        if (isset($data['email'])) {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = "Email должен быть заполнен";
            }
        } else {
            $errors['email'] = 'Поле email не указано';
        }
        if (isset($data['password'])) {
            $password = $data['password'];
            if (empty($password)) {
                $errors['password'] = "Пароль должен быть заполнен";
            }
            if (strlen($password) > 0 && strlen($password) < 8) {
                $errors['password'] = "Пароль должен быть не менее 8 символов";
            }
        } else {
            $errors['password'] = 'Поле password не указано';
        }
        return $errors;
    }

    private function validateLogin(array $data): array
    {
        $errors = [];
        if (isset($data['email'])) {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = "Email должен быть заполнен";
            }
        } else {
            $errors['email'] = 'Поле email не указано';
        }
        if (isset($data['password'])) {
            $password = $data['password'];
            if (empty($password)) {
                $errors['password'] = "Пароль должен быть заполнен";
            }
            if (strlen($password) > 0 && strlen($password) < 8) {
                $errors['password'] = "Пароль должен быть не менее 8 символов";
            }
        } else {
            $errors['password'] = 'Поле password не указано';
        }
        return $errors;
    }

    public function getLogin(): void
    {
        require_once './../View/get_login.phtml';
    }

    public  function postLogin(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = $this->validateLogin($_POST);
        if (empty($errors)) {
            $user = User::getOneByEmail($email);
            if ($user===false){
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