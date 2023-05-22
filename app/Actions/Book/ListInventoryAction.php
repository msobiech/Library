<?php

namespace Actions\Book;

class ListInventoryAction
{

    public function __construct()
    {
    }

    function action($db, $user): string
    {
        $output = '';
        $query = $db->prepare('SELECT title, Author.name as author_name, Author.surname as author_surname, Category.name as category_name, available FROM Book JOIN Author ON Book.author_id = Author.author_id JOIN Category ON Book.category_id = Category.category_id');
        $query->execute();
        $books = $query->fetchAll();

        if ($books) {
            foreach ($books as $book) {

                $output .= '<tr>
                    <td>' . $book['title'] . '</td>
                    <td>' . $book['author_name'] . ' ' . $book['author_surname'] . '</td>
                    <td>' . $book['category_name'] . '</td>
                    <td>' . ($book['available'] ? 'Tak' : 'Nie') . '</td>';

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
            <td colspan="5">Brak ksiazek w bibliotece</td>
          </tr>';
        }
        return $output;
    }
}