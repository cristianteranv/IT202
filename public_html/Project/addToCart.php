<?php
    $price = $_POST["price"];
    $userId = $_POST["userId"];
    $productId = $_POST["productId"];
    $quantity = $_POST["purchaseQuantity"];
    echo $price . $userId. $productId . $quantity;
?>