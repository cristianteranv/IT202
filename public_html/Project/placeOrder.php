<?php
    require("common.inc.php");
    try{
        $db = getDB();
        $userId = $_POST["userId"];
        $text = "";
        $stmt = $db->prepare("INSERT INTO Orders (userId, productId, quantity, price)
                                        SELECT userId, productId, quantity, price
                                        FROM Carts
                                        WHERE userId = :userId");
        $stmt->execute(array(":userId"=>$userId));
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            $text = $text . "Successfully placed the order!\n";
        }
        else{
            $text = $text . "Error while placing order.\n";
        }
        $stmt = $db->prepare("DELETE FROM Carts WHERE userId = :userId");
        $stmt->execute(array(":userId"=>$userId));
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            $text = $text . "Successfully emptied your cart.\n";
        }
        else{
            $text = $text .  "Error while emptying your cart.\n";
        }
        echo $text;
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
?>