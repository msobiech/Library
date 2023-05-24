<?php

namespace Actions\Auth;

use PDO;

class LoginAction
{

    public function __construct()
    {
    }

    function action($db, string $login, string $password): string
    {
        //implement login
        //$db = ;
        $query = $db->prepare('SELECT passwordhash FROM User WHERE login = :login AND isActive = 1');
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        if(!empty($result)){
            $passwd = $result[0]['passwordhash'];
        } else{
            return 'false';
        }
        return $password == $passwd ? 'true' : 'false';
    }
}