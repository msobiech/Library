<?php

namespace Actions\Book;
use PDO;

class ListInventoryAction
{

    public function __construct()
    {
    }

    function action($db, $user, $title, $author_name, $author_surname, $isbn, $category_id): string
    {
        $user = htmlspecialchars(strip_tags($user));
        $author_name = htmlspecialchars(strip_tags($author_name));
        $author_surname = htmlspecialchars(strip_tags($author_surname));
        $title = htmlspecialchars(strip_tags($title));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $isbn = htmlspecialchars(strip_tags($isbn));

        $output = '';
        $main_query = 'SELECT title, isbn, Author.name as author_name, Author.surname as author_surname, Category.name as category_name, available, lowtitle, Author.lowname, Author.lowsurname, Category.category_id FROM Book JOIN Author ON Book.author_id = Author.author_id JOIN Category ON Book.category_id = Category.category_id';
        $query_args = array();

        if(!empty($title)){
            $title = strtolower($title);
            $query_args[] = ' lowtitle LIKE :title';
        }
        if(!empty($author_name)){
            $author_name = strtolower($author_name);
            $query_args[] = ' Author.lowname LIKE :author_name';
        }
        if(!empty($author_surname)){
            $author_surname = strtolower($author_surname);
            $query_args[] = ' Author.lowsurname LIKE :author_surname';
        }
        if(!empty($category_id) && $category_id != -1){
            $query_args[] = ' Category.category_id = :category';
        }
        if(!empty($isbn)){
            $query_args[] = ' isbn = :isbn';
        }
        $search_query = "";
        if(count($query_args)) {
            $search_query = ' WHERE ' . $query_args[0];
        }
        for($i = 1; $i < count($query_args); $i++) {
            $search_query = $search_query . ' and ' . $query_args[$i];
        }
        $search_query = $main_query . $search_query;
        echo $search_query;
        $query = $db->prepare($search_query);

        if(!empty($title)){
            $query->bindValue(':title', '%'.$title.'%', PDO::PARAM_STR);

        }
        if(!empty($author_name)){
            $query->bindValue(':author_name', '%'.$author_name.'%', PDO::PARAM_STR);
        }
        if(!empty($author_surname)){
            $query->bindValue(':author_surname', '%'.$author_surname.'%', PDO::PARAM_STR);
        }
        if(!empty($category_id) && $category_id != -1){
            $query->bindValue(':category', $category_id, PDO::PARAM_INT);
        }
        if(!empty($isbn)){
            $query -> bindValue(':isbn', $isbn, PDO::PARAM_INT);
        }
        $query->execute();
        $books = $query->fetchAll();

        if ($books) {
            foreach ($books as $book) {

                $output .= '<tr>
                    <td>' . $book['title'] . '</td>
                    <td>' . $book['author_name'] . ' ' . $book['author_surname'] . '</td>
                    <td>' . $book['category_name'] . '</td>
                    <td>' . ($book['available'] ? 'Tak' : 'Nie') . '</td>
                    <td>' . ($book['isbn']) . '</td>';

                $id = $book['title'];
                if (isset($id) && isset($user)) {
                    $output .= '<td><a href="#" id="' . $book['title'] . '" class="btn btn-outline-success me-1 btn-sm rounded-pill py-0 rentBookLink" data-bs-toggle="modal" data-bs-target="#rent-book-modal"><i class="fa-solid fa-book-bookmark"></i> Wypożycz</a>';
                }
                $output .= '</td>
                  </tr>';
            }
        } else {
            $output .=
                '<tr>
            <td colspan="6">Brak ksiazek w bibliotece</td>
          </tr>';
        }
        return $output;
    }
}