<?php

namespace Request;

class LoginRequest extends Request
{
    public function getEmail(): string
    {
        return $this->body['email'];
    }

    public function getPassword(): string
    {
        return $this->body['password'];
    }
    private function validate(): array
    {
        $errors = [];
        if (isset($this->body['email'])) {
            $email = $this->body['email'];
            if (empty($email)) {
                $errors['email'] = "Email должен быть заполнен";
            }
        } else {
            $errors['email'] = 'Поле email не указано';
        }
        if (isset($this->body['password'])) {
            $password = $this->body['password'];
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
}