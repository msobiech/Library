<?php
    //dane do polaczenia sie z baza danych (latwiej jest je ustawic i zmieniac w jednym miejscu niz we wszyskich plikach php
    define('DB_HOST', 'mysql:host=0.0.0.0;dbname=Library;'); //host->adres bazy danych dbname->nazwa bazy danych
    define('DB_USER', 'user-new');
    define('DB_PASSWORD', 'password2');
    define('PDO_ATTR', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);

?>

