<?php

namespace Actions\Book;
use PDO;

class BookDetailsAction
{

    public function __construct()
    {
    }

    function action($db, $user, $id): string
    {
        $output = '';
        $main_query = 'select Book.book_id, title, ISBN, A.name as name, A.surname as surname, U.user_id as user, R.rent_id as rent_id, R.start as start, R.end as end from Book LEFT JOIN Rent R on Book.available = R.rent_id JOIN Author A on A.author_id = Book.author_id LEFT JOIN User U on U.user_id = R.user_id WHERE Book.book_id = :id';
        $query = $db->prepare($main_query);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $books = $query->fetchAll();
        if ($books) {
            foreach ($books as $book) {
                $output .= json_encode([
                    'id' => $book['book_id'],
                    'name' => $book['name'] . ' ' . $book['surname'],
                    'title' => $book['title'],
                    'ISBN' => $book['ISBN'],
                    'user' => $book['user'],
                    'rent_id' => $book['rent_id'],
                    'rent_start' => $book['start'],
                    'rent_end' => $book['end'],
                ]);
            }
        } else {
            $output .= json_encode([
                'id' => $id,
                'name' => 'ERROR 404',
                'title' => 'ERROR 404',
            ]);
        }
        return $output;
    }
}