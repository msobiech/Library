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

?>
