<?php
require("config.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
    $db = new PDO($connection_string, $dbuser, $dbpass);
    $stmt = $db->prepare("CREATE TABLE Products(
                id int AUTO_INCREMENT,
                name VARCHAR(64) NOT NULL UNIQUE,
                brand VARCHAR(64) NOT NULL,
                category VARCHAR(128),
                price decimal(10,2) default 0.00,
                stock int default 0,
                description TEXT,
                modified datetime default current_timestamp on update current_timestamp,
                created datetime default current_timestamp, 
            
                PRIMARY KEY (id))
                CHARACTER SET utf8 COLLATE utf8_general_ci");
    $r = $stmt->execute();
    echo var_export($stmt->errorInfo(), true);
    echo var_export($r, true);
}
catch (Exception $e){
    echo $e->getMessage();
}
?>