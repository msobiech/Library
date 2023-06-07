<?php

require_once __DIR__ . '/../app.php';
require_once 'util.php';

$util = new Util;

//Auth
if (isset($_POST['auth']) && isset($_POST['zaloguj'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    //echo 'true';
    echo $loginAction->action($db_connection, $login, $password, $_SERVER['REMOTE_ADDR']);
}

//rejestracja
if(isset($_POST['zarejestruj'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    try{
        echo $signupAction->action($db_connection, $login, $password);
    }catch(Exception $exception) {
        echo $util->showMessage('danger', $exception->getMessage());
    }

}

//Inventory
if (isset($_GET['inventory'])) {

    try {
        $user = $util->testInput($_GET['login']);
        $user = $util->empty2Null($user);
        $title = "";
        $author_name = "";
        $author_surname = "";
        $isbn = "";
        $category_id = "";
        if (isset($_GET['title'])) {
            $title = $util->testInput($_GET['title']);
        }
        if (isset($_GET['author_name'])) {
            $author_name = $util->testInput($_GET['author_name']);
        }
        if (isset($_GET['author_surname'])) {
            $author_surname = $util->testInput($_GET['author_surname']);
        }
        if (isset($_GET['isbn'])) {
            $isbn = $util->testInput($_GET['isbn']);
        }
        if (isset($_GET['category_id'])) {
            $category_id = $util->testInput($_GET['category_id']);
        }
        echo $listInventoryAction->action($db_connection, $user, $title, $author_name, $author_surname, $isbn, $category_id);
    }catch (Exception $exception) {
        echo $util->showMessage('danger', $exception->getMessage());
    }
}
if (isset($_GET['book']) && isset($_GET['id'])) {
    $user = $util->testInput($_GET['login']);
    //$user = $util->empty2Null($user);
    $id = $_GET['id'];
    //$user = $util->empty2Null($user);
    echo $BookDetailsAction->action($db_connection, $user, $id);
    //echo $listInventoryAction->action($db_connection, $user, $title, $author_name, $author_surname, $isbn, $category_id);
}


//Book
if(isset($_POST['book']) && $_POST['book'] == 'add' && isset($_POST['login'])){
    try {
        $title = $util->testInput($_POST['title']);
        $author_name = $util->testInput($_POST['author-name']);
        $author_surname = $util->testInput($_POST['author-surname']);
        $category_id = $util->testInput($_POST['category']);
        $isbn = $util->testInput($_POST['isbn']);
        $resadd = $addBookAction->action($db_connection, $_COOKIE['login'], $_SERVER['REMOTE_ADDR'], $title, $author_name, $author_surname, $category_id, $isbn);
        if ($resadd == 'true') {
            echo $util->showMessage('success', 'Ksiazka zostala dodana!');
        }
        if ($resadd == 'perms') {
            echo $util->showMessage('danger', 'No permissions to add book! Try logging in again.');
        }
    } catch (Exception $exception) {
        echo $util->showMessage('danger', $exception->getMessage());
    }
}
if(isset($_POST['book']) && $_POST['book'] == 'rent' && isset($_POST['login']) ){
    try {
        $book_id = $util->testInput($_POST['book-id']);
        $start = $util->testInput($_POST['min-date']);
        $end = $util->testInput($_POST['max-date']);
        $login = $util->testInput($_POST['login']);
        $RentBookAction->action($db_connection, $book_id, $start, $end, $login);

        echo $util->showMessage('success', 'Ksiazka zostala wypozyczona!');
    } catch (Exception $exception) {
        echo $util->showMessage('danger', $exception->getMessage());
    }
}

if(isset($_POST['book']) && $_POST['book'] == 'return' && isset($_POST['login']) ){
    try {
        $rent_id = $util->testInput($_POST['rent-id']);
        $today = $util->testInput($_POST['return_date']);
        $login = $util->testInput($_POST['login']);
        //$book_id = $util->testInput($_POST['book-id']);
        $ReturnBookAction->action($db_connection, $rent_id, $today);

        echo $util->showMessage('success', 'Ksiazka zostala zwrocona!');
    } catch (Exception $exception) {
        echo $util->showMessage('danger', $exception->getMessage());
    }
}

//Category
//TODO: TEN BRAK USERA POWODUJE WYPISANIE WARNINGA DO KODU HTML
if (isset($_GET['category'])) {
    //$user = $util->testInput($_GET['login']);
    //$user = $util->empty2Null($user);

    echo $listCategoryAction->action($db_connection, $user);
}

?>
