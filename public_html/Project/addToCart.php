<?php
    include("header.php");
    require("common.inc.php");
    $db = getDB();
    $price = $_POST["price"];
    $userId = $_POST["userId"];
    $productId = $_POST["productId"];
    $quantity = $_POST["purchaseQuantity"];
    if (!empty($userId) && !empty($price) && !empty($productId) && !empty($quantity)){
        $stmt = $db->prepare("INSERT INTO Carts VALUES")
    }
?>