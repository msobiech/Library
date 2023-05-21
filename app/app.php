<?php

use Actions\Auth\LoginAction;
include('Actions/Auth/LoginAction.php');
//global $db_connection;


try {
    define('DB_HOST', 'mysql:host=0.0.0.0;dbname=Library;'); //host->adres bazy danych dbname->nazwa bazy danych
    define('DB_USER', 'user-new');
    define('DB_PASSWORD', 'password2');
    define('PDO_ATTR', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    $db_connection = new PDO(DB_HOST, DB_USER, DB_PASSWORD, PDO_ATTR);
} catch (PDOException $e){
    echo 'Error: '.$e->getMessage();
}

//Init Actions
$loginAction = new LoginAction();
