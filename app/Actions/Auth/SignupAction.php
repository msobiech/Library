<?php

namespace Actions\Auth;
use PDO;

class SignupAction
{
    function action($db, string $login, string $password): string
    {
        // returns a new sessionid when login is successful
        $login = htmlspecialchars(strip_tags($login));
        $password = htmlspecialchars(strip_tags($password));
        $login_query = $db->prepare('SELECT * FROM User WHERE login = :userlogin');
        $login_query->bind_value(':userlogin', $login, PDO::PARAM_STR);
        $login_query->execute();
        $users = $login_query->fetch_all();
        if(empty($users)){
            return 'Konto o takiej nazwie już istnieje';
        }
        $query = $db->prepare('INSERT INTO User (login, password_hash) VALUES (:login, :passHash)');
        $query->bind_value(':login', $login, PDO::PARAM_STR);
        $query->bind_value(':passHash', password_hash($password));
        $query->execute();
        return 'Pomyślnie utworzono konto';
    }
}