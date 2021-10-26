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
        }else if($arg1 === "all"){
            return $db->select($sql);
        }else{
            if(!empty($_GET["num"]) && is_numeric($_GET["num"]) && $_GET["num"]>0){
                $num = $_GET["num"];
                $arr = array_reverse(array_slice($db->select($sql), -1*$num, $num));
                $filter_arr = array_filter($arr, function($key){
                    $div = ceil(($_GET["num"]+1)/1009);
                    return $key % $div === 0;
                },ARRAY_FILTER_USE_KEY);
                return array_values($filter_arr);
            }
            return end($db->select($sql));
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