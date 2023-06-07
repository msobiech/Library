<?php

namespace Actions\Auth;
require_once ('authutil.php');
use PDO;

class LoginAction
{

    public function __construct()
    {
    }

    function action($db, string $login, string $password, $ip): string
    {
        // returns a new sessionid when login is successful
        $login = htmlspecialchars(strip_tags($login));
        $password = htmlspecialchars(strip_tags($password));
        $query = $db->prepare('SELECT * FROM User WHERE login = :login AND isActive = 1');
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute();
        $useri = $query->fetchAll();
        if(!empty($useri)){
            $passhash = $useri[0]['passwordhash'];
        } else{
            return 'Próba logowania zakończyła się niepowodzeniem';
        }
        if (password_verify($password, $passhash)) {
            $sessid = randStr(256);
            try {
                $db->begintransaction();
                $query2 = $db->prepare('INSERT INTO Sessions (sessid, user_id, permission, expire) VALUES (:ssid, :usid, :perms, :exp)');
                $query2->bindValue(':ssid', $sessid, PDO::PARAM_STR);
                //$query2->bindValue(':cip', inet_pton($ip), PDO::PARAM_STR);
                $query2->bindValue(':usid', $useri[0]['user_id'], PDO::PARAM_INT);
                $query2->bindValue(':perms', $useri[0]['permission'], PDO::PARAM_INT);
                $query2->bindValue(':exp', time(), PDO::PARAM_INT);
                $query2->execute();
                $db->commit();
            } catch(Exception $e) {
                $db->rollback();
                throw new Exception($e->getMessage(), 1, $e);
            }
            return $sessid;
        } else {
            return 'Próba logowania zakończyła się niepowodzeniem';
        }
    }
}