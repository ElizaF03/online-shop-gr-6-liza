<?php

class UserController
{

    public function getRegistrate()
    {
        require_once './../View/get_registrate.phtml';
    }

    public function postRegistrate()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = $this->validate($_POST);

        if (empty($errors)) {
            require_once './../Model/User.php';
            $userModel = new User();
            $data = $userModel->lookEmail($email);
            if ($data === false) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $userModel->addInfo($username, $email, $hash);
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

    public function getLogin()
    {
        require_once './../View/get_login.phtml';
    }

    public function postLogin()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = $this->validateLogin($_POST);
        if (empty($errors)) {
            require_once './../Model/User.php';
            $userModel = new User();
            $user = $userModel->lookEmail($email);
            if ($user === false) {
                echo 'Пользователь не зарегистрирован';
            } else {
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];

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