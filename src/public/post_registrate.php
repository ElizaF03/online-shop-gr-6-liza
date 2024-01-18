<?php

$username= $_POST['username'];
$email= $_POST['email'];
$password= $_POST['password'];

$pdo= new PDO("pgsql:host=postgres; port=5432; dbname=test_db", username:"elizaveta", password:"qwerty");
$pdo->exec("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");