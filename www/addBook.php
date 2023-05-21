<?php
    if(isset($_POST['submit'])){
        //polaczenie z baza
        require_once('connectConfig.php');
        try {
            $db = new PDO(DB_HOST, DB_USER, DB_PASSWORD, PDO_ATTR);
        } catch (PDOException $e){
            echo 'Error: '.$e->getMessage();
        }
        //zabezpieczenie danych z wejscia (moze sa lepsze sposoby na robienie tego)
        $book_title = htmlspecialchars(trim($_POST['book_title']), ENT_QUOTES, "UTF-8");
        $author = htmlspecialchars(trim($_POST['author']), ENT_QUOTES, "UTF-8");
        $genre = htmlspecialchars(trim($_POST['genre']), ENT_QUOTES, "UTF-8");
        $ISBN = htmlspecialchars(trim($_POST['ISBN']), ENT_QUOTES, "UTF-8");
        if(empty($book_title) || empty($author) || empty($genre)){
            header('Location: bookForm.html');
            exit();
        }
        //sprawdzenie czy dany autor istnieje

        //szukamy id autora LIMIT 1 poniewaz chcemy miec jedno id
        $author_query = $db->prepare('SELECT author_id FROM Author WHERE name = :name LIMIT 1');
        $author_query->bindValue(':name', $author, PDO::PARAM_STR);
        $author_query->execute();
        $query_res = $author_query->fetchAll();
        if(!empty($query_res)){
            $author_id = $query_res[0]['author_id'];
            echo'<p>author ID: ' . $author_id .'</p>';
        }else{
            //nie ma autora w bazie -> dodajemy go i szukamy id
            //TODO: OBECNIE KOD WPISUJE IMIE I NAZWISKO AUTORA DWA RAZY
            $add_query = $db->prepare('INSERT INTO Author (name, surname) VALUES (:author_name, :author_surname)');
            $add_query->bindValue(':author_name', $author, PDO::PARAM_STR);
            $add_query->bindValue(':author_surname', $author, PDO::PARAM_STR);
            $add_query->execute();
            //przypisanie id autora
            $author_query->execute();
            $query_res = $author_query->fetchAll();
            $author_id = $query_res[0]['author_id'];
        }

        //szukamy id gatunku
        $genre_query = $db->prepare('SELECT category_id FROM Category WHERE name = :genre LIMIT 1');
        $genre_query->bindValue(':genre', $genre, PDO::PARAM_STR);
        $genre_query->execute();
        $query_res = $genre_query->fetchAll();
        if(!empty($query_res)){
            $genre_id = $query_res[0]['category_id'];
            echo'<p>genre ID: ' . $genre_id .'</p>';
        }else{
            //nie ma gatunku w bazie -> dodajemy go i szukamy id
            //TODO: Obecnie w nie ma wpisywanego opisu gatunku
            $add_query = $db->prepare('INSERT INTO Category (name, description) VALUES (:genre_name, :genre_description)');
            $add_query->bindValue(':genre_name', $genre, PDO::PARAM_STR);
            $add_query->bindValue(':genre_description', $genre, PDO::PARAM_STR);
            $add_query->execute();
            //przypisanie id gatunku
            $genre_query->execute();
            $query_res = $genre_query->fetchAll();
            $genre_id = $query_res[0]['category_id'];
        }
        //juz mamy id autora i gatunku wiec dodajemy ksiazke do bazy
        $add_book_query = $db->prepare('INSERT INTO Book (title, author_id, category_id, ISBN) VALUES (:title, :author_id, :category_id, :ISBN)');
        $add_book_query->bindValue(':title', $book_title, PDO::PARAM_STR);
        $add_book_query->bindValue(':author_id', $author_id, PDO::PARAM_INT);
        $add_book_query->bindValue(':category_id', $genre_id, PDO::PARAM_INT);
        $add_book_query->bindValue(':ISBN', $ISBN, PDO::PARAM_STR);
        $add_book_query->execute();
        echo 'Dodano ksiazke<br/> <a href="showBooks.php">Zobacz wszystkie książki</a>';
    }else{
        header('Location: bookForm.html');
        exit();
    }
?>
