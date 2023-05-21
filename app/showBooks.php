<?php
    //polaczenie z baza
    require_once('connectConfig.php');
    try {
        $db = new PDO(DB_HOST, DB_USER, DB_PASSWORD, PDO_ATTR);
    } catch (PDOException $e){
        echo 'Error: '.$e->getMessage();
    }
    $main_query = 'SELECT title, Author.name as author_name, Category.name as category_name FROM Book JOIN Author ON Book.author_id = Author.author_id JOIN Category ON Book.category_id = Category.category_id';
    $query =$db->query($main_query);
    $books = $query->fetchAll();

    //pobieranie id autora i gatunkow do formularza
    $author_query = $db->query('SELECT author_id, name FROM Author');
    $author_ids = $author_query->fetchAll();

    $genre_query = $db->query('SELECT category_id, name FROM Category');
    $genre_ids = $genre_query->fetchAll();

    if(isset($_GET['submit'])){
        //tablica z parametrami zapytania
        $query_args = array();
        echo 'Żądanie GET';
        echo $_GET['searched_title'];
        if(!isset($_GET['searched_title']) && !isset($_GET['author_id']) && !isset($_GET['genre_id'])){
            echo 'żadne pole nie jest wypelnione';
        }

        //tworzenie zapytania
        if(isset($_GET['searched_title'])){
            $title = htmlspecialchars(trim($_GET['searched_title']), ENT_QUOTES, "UTF-8");
            $query_args[] = ' title LIKE :searched_title';
        }
        if(isset($_GET['author_id']) && $_GET['author_id'] != -1){
            $searched_author_id = htmlspecialchars(trim($_GET['author_id']), ENT_QUOTES, "UTF-8");
            $query_args[] = ' Book.author_id = :author_id';
        }
        if(isset($_GET['genre_id']) && $_GET['genre_id'] != -1){
            $searched_genre_id = htmlspecialchars(trim($_GET['genre_id']), ENT_QUOTES, "UTF-8");
            $query_args[] = ' Book.category_id = :genre_id';
        }
        $search_query = ' WHERE ' . $query_args[0];
        for($i = 1; $i < count($query_args); $i++){
            $search_query = $search_query . ' and ' . $query_args[$i];
        }
        $search_query = $main_query . $search_query;
        echo $search_query;
        //wykonanie zapytania
        $query = $db->prepare($search_query);
        if(isset($title)){
            $query->bindValue(':searched_title', '%'.$title.'%', PDO::PARAM_STR);
        }
        if(isset($searched_author_id)){
            $query->bindValue(':author_id', $searched_author_id, PDO::PARAM_INT);
        }
        if(isset($searched_genre_id)){
            $query->bindValue(':genre_id', $searched_genre_id, PDO::PARAM_INT);
        }



        $query->execute();
        $books = $query->fetchAll();
        /*$search_query = $main_query . ' WHERE title LIKE :searched_title';
        echo $search_query;
        $query = $db->prepare($search_query);
        $query->bindValue(':searched_title', '%'.$title.'%', PDO::PARAM_STR);
        $query->execute();
        $books = $query->fetchAll();*/
    }
    ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Lista książek</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Lista książek</h1>
    <p>Jeśli chcesz wyszukać konkretne pozycję, możesz skorzystać z wyszukiwarki</p>
    <form method="get" action="showBooks.php">
        <label>Tytuł: </label>
        <input type="text" name="searched_title" id="searched_title"/>
        <label>Autor: </label>
        <select name="author_id" id="author_id">
            <option value="-1">Wybierz autora</option>
            <?php
                foreach ($author_ids as $author_id){
                    echo "<option value='". $author_id['author_id'] ."'>" . $author_id['name'] . "</option>";
                }
            ?>
        </select>
        <select name="genre_id" id="genre_id">
            <option value="-1">Wybierz gatunek</option>
            <?php
                foreach ($genre_ids as $genre_id){
                    echo "<option value='". $genre_id['category_id'] ."'>" . $genre_id['name'] . "</option>";
                }
            ?>
        </select>
        <input type="submit" name="submit" value="Wyszukaj"/>
    </form>
    <?php
        foreach ($books as $book){
            echo '<p>Tytuł: ' . $book['title'] . ' Autor: ' . $book['author_name'] . ' Gatunek: ' . $book['category_name'] . '</p><hr/>';
        }
    ?>
</body>
</html>
