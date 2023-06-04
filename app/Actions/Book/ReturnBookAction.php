<?php

namespace Actions\Book;
use PDO;

class ReturnBookAction
{

    public function __construct()
    {
    }

    function action($db, $rent_id, $date): string
    {
        try {
            $db->begintransaction();
            $main_query = 'UPDATE Rent SET end = :date WHERE rent_id = :rent_id';
            $query = $db->prepare($main_query);
            $query->bindValue(':date', $date, PDO::PARAM_STR);
            $query->bindValue(':rent_id', $rent_id, PDO::PARAM_INT);
            $query->execute();
            $db->commit();
        } catch(Exception $e){
            $db->rollback();
            throw new Exception($e->getMessage(), 1, $e);
        }
        return '';
    }
}