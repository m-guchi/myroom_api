<?php

include(__DIR__ . '/../config/database.php');

class DB
{
    function pdo() {
        global $myroom;
        try {
            $driver_options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($myroom["dsn"], $myroom["user"], $myroom["password"], $driver_options);
        } catch (PDOException $e) {
            echo "error:".$e->getMessage();
            die();
        }
        return $pdo;
    }

    function select($sql){
        $pdo = $this->pdo();
        $sth = $pdo->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
