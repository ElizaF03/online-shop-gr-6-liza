<?php

class UserController
{
public function getRegistrate()
{
require_once './../View/get_registrate.php';
}
public function postRegistrate()
{
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    $errors =$this->validate($_POST);

    if(empty($errors)){
        $pdo= new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username:"elizaveta", password:"qwerty");
        $hash= password_hash($password, PASSWORD_DEFAULT);
        $stmt=$pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :hash)');
        $stmt=$pdo->prepare('SELECT * FROM users WHERE email =:email LIMIT 1');
        $stmt->execute(['email'=>$email]);
        $data=$stmt->fetch();
        if($data === false){
            $stmt=$pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :hash)');
            $stmt->execute(['username'=>$username, 'email'=>$email,'hash'=>$hash]);
        }else{
            echo 'Такой позльзователь уже зарегистрирован';
        }
    }

    require_once './get_registrate.php';
}
private function validate(array $data):array
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
    }else{
        $errors['email']= 'Поле username не указано';
    }
    if(isset($data['email'])){
        $email= $data['email'];
        if (empty($email)){
            $errors['email']= "Email должен быть заполнен";
        }
    }else{
        $errors['email']= 'Поле email не указано';
    }
    if(isset($data['password'])){
        $password= $data['password'];
        if (empty($password)){
            $errors['password']=  "Пароль должен быть заполнен";
        }
        if(strlen($password)>0 && strlen($password)<8){
            $errors['password']= "Пароль должен быть не менее 8 символов";
        }
    }else{
        $errors['password']= 'Поле password не указано';
    }
    return $errors;
}
}