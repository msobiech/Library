<?php

namespace Actions\Auth;
use PDO;
use Exception;
class SignupAction
{
    function action($db, string $login, string $password): string
    {
        // returns a new sessionid when login is successful
        try {
            $login = htmlspecialchars(strip_tags($login));
            $password = htmlspecialchars(strip_tags($password));
            $login_query = $db->prepare('SELECT * FROM User WHERE login LIKE :userlogin');
            $login_query->bindvalue(':userlogin', $login, PDO::PARAM_STR);

            $login_query->execute();
            $users = $login_query->fetchAll();
        }catch(Exception $e){
            throw new Exception($e->getMessage(), 1, $e);
        }
        if(!(empty($users))){
            return 'Konto o takiej nazwie już istnieje';
        }
        try {
            $db->begintransaction();
            $query = $db->prepare('INSERT INTO User (login, passwordhash) VALUES (:login, :passHash)');
            $query->bindvalue(':login', $login, PDO::PARAM_STR);
            $query->bindvalue(':passHash', password_hash($password, null));
            $query->execute();
            $db->commit();
            return 'Pomyślnie utworzono konto';
        } catch(Exception $e){
            $db->rollback();
            throw new Exception($e->getMessage(), 1, $e);
        }
    }
}