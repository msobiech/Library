<?php

//use Carbon\Carbon;

use Actions\Auth\LoginAction;

require_once __DIR__ . '/../app.php';
require_once 'util.php';

$util = new Util;

//Auth
if (isset($_POST['auth']) && isset($_POST['zaloguj'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    //echo 'true';
    echo $loginAction->action($db_connection, $login, $password);
}

//Inventory
if (isset($_GET['inventory'])) {
    $user = $util->testInput($_GET['login']);
    $user = $util->empty2Null($user);
    echo $listInventoryAction->action($db_connection, $user);
}

if(isset($_POST['title']) && isset($_POST['author']) && isset($_POST['category']) && isset($_POST['isbn'])){
    echo 'formularz wyslany';
    $title = $util->testInput($_POST['title']);
    $author = $util->testInput($_POST['author']);
    $category = $util->testInput($_POST['category']);
    $isbn = $util->testInput($_POST['isbn']);
    echo $addInventoryAction->action($db_connection, $title, $author, $category, $isbn);
}
?>
