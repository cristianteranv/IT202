<?php
function get($arr, $key, $default = ""){
    if(is_array($arr) && isset($arr[$key])){
        return $arr[$key];
    }
    return $default;
}
function getDB(){
    global $db;
    if(!isset($db)) {
        require_once("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db = new PDO($connection_string, $dbuser, $dbpass);
    }
    return $db;
}

function flash($message, $type = "info") {
    if (!isset($_SESSION["messages"])) {
        $_SESSION["messages"] = [];
    }
    array_push($_SESSION["messages"], ["message"=>$message, "type"=>$type]);
    //error_log(var_export($_SESSION["messages"], true));
}

function getFlashMessages() {
    $messages = get($_SESSION, "messages", []);
    //error_log("Get Flash Messages(): " . var_export($messages, true));
    $_SESSION["messages"] = [];
    return $messages;
}

function response($data, $status = 200, $message = ""){
    return array("status" => $status, "message" => $message, "data" => $data);
}

function is_logged_in($redirect = true){
    if(get($_SESSION, "user", false)){
        return true;
    }
    if($redirect){
        flash("You must be logged in to access that page.", "warning");
        die(header("Location: login.php"));
    }
    else{
        return false;
    }
}

function alert($message){
    echo "<script type=\'text/javascript\'>alert(\'$message\')</script>";
}

?>