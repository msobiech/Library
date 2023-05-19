<?php
    //polaczenie z baza
    require_once('connectConfig.php');
    try {
        $db = new PDO(DB_HOST, DB_USER, DB_PASSWORD, PDO_ATTR);
    } catch (PDOException $e){
        echo 'Error: '.$e->getMessage();
    }
    $query =$db->query('SELECT title, Author.name as author_name, Category.name as category_name FROM Book JOIN Author ON Book.author_id = Author.author_id JOIN Category ON Book.category_id = Category.category_id');
    $books = $query->fetchAll();
    ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Lista książek</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Lista książek</h1>
    <?php
        foreach ($books as $book){
            echo '<p>Tytuł: ' . $book['title'] . ' Autor: ' . $book['author_name'] . ' Gatunek: ' . $book['category_name'] . '</p><hr/>';
        }
    ?>
</body>
</html>
