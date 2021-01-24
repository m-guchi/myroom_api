<?php
class DhtController
{
    public $code = 200;
    
    public function get() :array
    {
        $db = new DB();
        $sql = "SELECT * FROM dht";
        return $db->select($sql);
    }

    public function post() :array
    {
        parse_str(file_get_contents('php://input'),$post);
        if(array_key_exists("time", $post)
            && array_key_exists("temp", $post)
            && array_key_exists("humid", $post)
        ){
            $pdo = new DB();
            $sql = "INSERT INTO dht 
                    (time,temp,humid)
                VALUES 
                    (:time,:temp,:humid)";
            $sth = $pdo->pdo()->prepare($sql);
            $sth->bindValue(':time', $post["time"]);
            $sth->bindValue(':temp', $post["temp"]);
            $sth->bindValue(':humid', $post["humid"]);
            return ["ok" => $sth->execute()];
        }else{
            return ["ok" => false];
        }
    }
}