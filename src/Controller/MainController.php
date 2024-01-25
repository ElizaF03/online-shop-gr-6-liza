<?php

class MainController
{
public function getCatalog()
    {
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: /get_login.php');
        }
    require_once './../View/catalog.php';
    }
}