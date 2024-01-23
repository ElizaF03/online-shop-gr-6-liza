<?php


$email = $_POST['email'];
$password = $_POST['password'];
function validate(array $data): array
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

$errors = validate($_POST);

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username: "elizaveta", password: "qwerty");
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email =:email');
    $stmt->execute(['email'=>$email]);
    $user = $stmt->fetch();
if($user === false){
    echo 'Пользователь не зарегистрирован';
}else{

    if(password_verify($password, $user['password'])){
        session_start();
        $_SESSION['user_id']=$user['id'];


        header('Location: /main.php');
        echo 'Авторизация прошла успешно' ;
    }else{
        echo 'Неверный пароль или логин';
    }
}


}

require_once './get_login.php';

