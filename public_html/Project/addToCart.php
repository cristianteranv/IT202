<?php
    include("header.php");
    require("common.inc.php");
    $db = getDB();
    if (isset($_POST["userId"]) && isset($_POST["productId"]) && isset($_POST["purchaseQuantity"]) && isset($_POST["price"])) {
        try {
            $userId = $_POST["userId"];
            $productId = $_POST["productId"];
            $quantity = $_POST["purchaseQuantity"];
            $price = $_POST["price"];
            $stmt = $db->prepare("INSERT INTO Carts(userId, productId, quantity, price) VALUES (:userId, :productId, :quantity, :price)");
            $result = $stmt->execute(array(
                ":userId" => $userId,
                ":productId" => $productId,
                ":quantity" => $quantity,
                ":price" => $price
            ));
            echo "success";
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Error while receiving data.";
    }
?>