<?php

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

//Book
if(isset($_POST['book']) && isset($_POST['title'])){
    try {
        $title = $util->testInput($_POST['title']);
        $author = $util->testInput($_POST['author']);
        $category_id = $util->testInput($_POST['category']);
        $isbn = $util->testInput($_POST['isbn']);
        $addBookAction->action($db_connection, $title, $author, $category_id, $isbn);
        echo $util->showMessage('success', 'Ksiazka zostala dodana!');
    } catch (Exception $exception) {
        echo $util->showMessage('danger', $exception->getMessage());
    }
}

//Category
if (isset($_GET['category'])) {
    //$user = $util->testInput($_GET['login']);
    //$user = $util->empty2Null($user);

    echo $listCategoryAction->action($db_connection, $user);
}

?>
