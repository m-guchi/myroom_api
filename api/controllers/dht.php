<?php
class DhtController
{
    public $code = 200;
    
    public function get($arg1=null) :array
    {
        $db = new DB();
        $sql = "SELECT * FROM dht";
        if($arg1 === "last"){
            return end($db->select($sql));
        }else{
            return $db->select($sql);
        }
    }

    public function post() :array
    {
        parse_str(file_get_contents('php://input'),$post);
        if(array_key_exists("time", $post)
            && array_key_exists("temp", $post)
            && array_key_exists("humid", $post)
            && array_key_exists("press", $post)
        ){
            $pdo = new DB();
            $sql = "INSERT INTO dht 
                    (time,temp,humid,press)
                VALUES 
                    (:time,:temp,:humid,:press)";
            $sth = $pdo->pdo()->prepare($sql);
            $sth->bindValue(':time', $post["time"]);
            $sth->bindValue(':temp', $post["temp"]);
            $sth->bindValue(':humid', $post["humid"]);
            $sth->bindValue(':press', $post["press"]);
            return ["ok" => $sth->execute()];
        }else{
            return ["ok" => false];
        }
    }
}