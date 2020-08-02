<?php
    require("common.inc.php");
    $db = getDB();
    try{
        $cartId = $_POST["cartId"];
        $quantity = $_POST["quantity"];
        if ($quantity == 0 ){
            $stmt = $db->prepare("DELETE FROM Carts WHERE id = :id");
            $stmt->execute(array(":id"=>$cartId));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000"){
                echo "Error while removing item from cart";
            }
            else{
                echo "Successfully removed from cart";
            }
        }
        else{
            $stmt = $db->prepare("UPDATE Carts SET quantity = :quantity WHERE id = :id");
            $stmt->execute(array(
                ":quantity" => $quantity,
                ":id" => $cartId)
            );
            $e = $stmt->errorInfo();
            if ($e[0] != "00000"){
                echo "Error while updating quantity for this item";
            }
            else{
                echo "Successfully updated quantity";
            }
        }
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
?>