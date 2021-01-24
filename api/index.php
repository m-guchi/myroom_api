<?php
include(__DIR__ . '/../DB.php');

function htmlescape($val){
    return htmlspecialchars($val);
}

preg_match('|' . dirname($_SERVER['SCRIPT_NAME']) . '/([\w%/]*)|', $_SERVER['REQUEST_URI'], $matches);
$paths = explode('/', $matches[1]);
$file = array_shift($paths);
$params = array_map("htmlescape",$paths);

$file_path = './controllers/' . $file . '.php';
if (file_exists($file_path)) {
    include($file_path);
    $className = ucfirst($file) . "Controller";
    $methodName = strtolower($_SERVER['REQUEST_METHOD']);
    $obj = new $className();
    $res = json_encode($obj->$methodName(...$params));
    $code = $obj->code ?? 200;
    
    header("Content-Type: application/json; charset=utf-8", true, $code);
    echo $res;
}else{
    header("HTTP/1.1 404 Not Found");
    include('404.html');
    exit;
}