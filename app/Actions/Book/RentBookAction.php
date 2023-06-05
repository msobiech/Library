<?php

namespace Actions\Book;
use PDO;

class RentBookAction
{

    public function __construct()
    {
    }

    function action($db, $id, $start, $end, $login): string
    {
        $user_id = '';
        $user_query = 'SELECT user_id FROM Sessions WHERE sessid = :login';
        $uquery = $db->prepare($user_query);
        $uquery->bindValue(':login', $login, PDO::PARAM_STR);
        $uquery->execute();
        if($uquery){
            foreach ($uquery as $user){
                $user_id=$user['user_id'];
            }
        }
        if($user_id==''){
            throw new Exception('Nie znaleziono uzytkownika' . $login, 1);
        }
        $output = '';
        try {
            $db->begintransaction();
            $main_query = 'INSERT INTO Rent (book_id,user_id,start,end) VALUES (:book_id, :user_id, :start, :end)';

            $query = $db->prepare($main_query);
            $query->bindValue(':book_id', $id, PDO::PARAM_INT);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $query->bindValue(':start', $start, PDO::PARAM_STR);
            $query->bindValue(':end', $end, PDO::PARAM_STR);
            $query->execute();
            $db->commit();
        } catch(Exception $e){
            $db->rollback();
            throw new Exception($e->getMessage() . '   ' . $login, 1, $e);
        }
        return $output;
    }
}