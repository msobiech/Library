<?php

namespace Actions\Book;
use PDO; //korzystam z PDO w bindValue (bez tego nie dziala od linii 21)

class AddInventoryAction
{

    public function __construct()
    {
    }

    function action($db, $title, $author, $category, $isbn): string
    {
        $output = 'OK'; //nie wiem czy output tutaj jest potrzebny
        //$query = $db->prepare('SELECT title, Author.name as author_name, Author.surname as author_surname, Category.name as category_name, available FROM Book JOIN Author ON Book.author_id = Author.author_id JOIN Category ON Boo');
        //$query->execute();
        //ponizszy kod jest skopiowany z addBook.php

        //szukanie id autora
        $author_query = $db->prepare('SELECT author_id FROM Author WHERE name = :name LIMIT 1');
        $author_query->bindValue(':name', $author, PDO::PARAM_STR);
        $author_query->execute();
        $query_res = $author_query->fetchAll();
        if(!empty($query_res)){
            $author_id = $query_res[0]['author_id'];
            //$output = $output.'<p>author ID: ' . $author_id .'</p>';
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
        $genre_query->bindValue(':genre', $category, PDO::PARAM_STR);
        $genre_query->execute();
        $query_res = $genre_query->fetchAll();
        if(!empty($query_res)){
            $genre_id = $query_res[0]['category_id'];
            //$output = $output.'<p>genre ID: ' . $genre_id .'</p>';
        }else{
            //nie ma gatunku w bazie -> dodajemy go i szukamy id
            //TODO: Obecnie w nie ma wpisywanego opisu gatunku
            $add_query = $db->prepare('INSERT INTO Category (name, description) VALUES (:genre_name, :genre_description)');
            $add_query->bindValue(':genre_name', $category, PDO::PARAM_STR);
            $add_query->bindValue(':genre_description', $category, PDO::PARAM_STR);
            $add_query->execute();
            //przypisanie id gatunku
            $genre_query->execute();
            $query_res = $genre_query->fetchAll();
            //$genre_id = $query_res[0]['category_id'];
        }
        //juz mamy id autora i gatunku wiec dodajemy ksiazke do bazy
        $add_book_query = $db->prepare('INSERT INTO Book (title, author_id, category_id, ISBN) VALUES (:title, :author_id, :category_id, :ISBN)');
        $add_book_query->bindValue(':title', $title, PDO::PARAM_STR);
        $add_book_query->bindValue(':author_id', $author_id, PDO::PARAM_INT);
        $add_book_query->bindValue(':category_id', $genre_id, PDO::PARAM_INT);
        $add_book_query->bindValue(':ISBN', $isbn, PDO::PARAM_STR);
        $add_book_query->execute();
        return $output;
    }
}