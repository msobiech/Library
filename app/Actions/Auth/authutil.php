<?php

function randStr($len): string
{
    //$legalC = '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
    $legalC = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $res = '';
    for ($i = 0; $i < $len; $i++) {
        $res = $res . $legalC[random_int(0, strlen($legalC) - 1)];
    }
    return $res;
}

function confirmPerms($db, $ssid, $ip): int
{
    $ssid = htmlspecialchars(strip_tags($ssid));
    $query = $db->prepare('SELECT permission FROM Sessions WHERE sessid = :seid AND expire > :expire');
    $query->bindValue(':seid', $ssid, PDO::PARAM_STR);
    //$query->bindValue(':cip', inet_pton($ip), PDO::PARAM_STR);
    $query->bindValue(':expire', time(), PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll();
    if(!empty($result)){
        return $result[0]['permission'];
    } else{
        return 0;
    }
}
?>
