<?php

if(isset($_POST['username'])){
    $username= $_POST['username'];
}
if(isset($_POST['email'])){
    $email= $_POST['email'];
}
if(isset($_POST['password'])){
    $password= $_POST['password'];
}

if(!empty($username) && strlen($username)>2 && !empty($email) && !empty($password) && strlen($password)>=8){
    $pdo= new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username:"elizaveta", password:"qwerty");
    $stmt=$pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
    $stmt->execute(['username'=>$username, 'email'=>$email,'password'=>$password]);

}else{
    print_r("Ошибка: \n") ;
    if (empty($username)){
        echo "Имя должно быть заполнено";
    }
    if(strlen($username)>0 && strlen($username)<2){
        echo "Имя должно быть не менее 2-х символов\n";
    }
    if (empty($email)){
        echo "Email должен быть заполнен\n";
    }
    if (empty($password)){
        echo "Пароль должен быть заполнен\n";
    }
    if(strlen($password)>0 && strlen($password)<8){
        echo "Пароль должен быть не менее 8 символов\n";
    }
}

